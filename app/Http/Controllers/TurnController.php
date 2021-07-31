<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\util\Log;
use App\Models\Turn;
use App\Models\Client;
use App\Models\CatQueues;
use Carbon\Carbon;
use Exception;

class TurnController extends Controller
{
    /**
     * Función de conulta de Turnos
     */
    public function allTurn(Request $request) {
        try
        {
            /* Verificar si los próximos 5 turnos fueron atendidos */
            static::verificacionTurno();

            /* Consulta de los últimos 5 turnos atendidos  */
            $turns_delete = Turn::withTrashed()->join('client', 'client.id', 'turn.client_id')
                            ->join('cat_queues', 'cat_queues.id', 'turn.cat_queues_id')
                            ->whereNotNull('turn.deleted_at')->orderBy('turn.deleted_at','desc')
                            ->select('turn.*', 'client.name as client', 'cat_queues.name as queues')->limit(5)->get();

            /* Consulta de los próximos 5 turnos a ser atendidos */
            $turns_at = Turn::join('client', 'client.id', 'turn.client_id')
                            ->join('cat_queues', 'cat_queues.id', 'turn.cat_queues_id')
                            ->orderBy('turn_at','asc')->select('turn.*', 'client.name as client', 'cat_queues.name as queues')
                            ->limit(5)->get();

            /* Unificar los datos a ser mostrados en la tabla */
            $turns = Array();

            foreach ($turns_delete as $td) :
                array_push($turns, $td);
            endforeach;

            foreach ($turns_at as $t) :
                array_push($turns, $t);
            endforeach;
            
            return response()->json(['status' => true, 'response' => $turns ], 200);
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::write('TurnController', 'allTurn', $exception, 'Error');

            return response()->json(['status' => false, 'response' => $exception], 500);
        }
    }

    /**
     * Función de Insertar Turno
     */
    public function insertTurn(Request $request) {
        DB::beginTransaction();
        try
        {
            $data = $request->json()->all();
            /* Verificación de recibir el token */
            if (!isset($data['client'])) 
                return response()->json(['status' => false, 'response' => 'Falta los datos del cliente'], 400);
            
            /* Consulta del catálogo de Cola, la que tiene menor tiempo y cálculo en Minutos convertido en número */
            $catQueue = CatQueues::select('id', DB::raw("TO_NUMBER(TO_CHAR(time_queues::interval, 'MI'), '99G999D9S')  as time_queues")) 
                                    ->orderBy('time_queues', 'ASC')->first();

            /* Crear o Editar el CLiente, condicionado por la identificacion */
            $client = Client::updateOrCreate(
                [
                    'identification' => ($data['client']['identification'])
                ],
                [
                    'name' => ucwords($data['client']['name']),
                    'identification' => ($data['client']['identification']),
                ]);
   

            /* Respuesta en el caso de que no exista el cliente */
            if (!isset($client))
                return response()->json(['status' => false, 'response' => 'No existe el cliente'], 400);
           
            /* Fecha y Hora Actual */
            $date = Date('Y-m-d H:i:s');
            $carbon = new Carbon($date);          
            
            /* Consulta de turnos, tomando en cuanta los que ya han pasado con unión a la tabla de catálogo de cola 
            * Calcuando el tiempo de acuerdo al último turno de cada cola
            */
            $turns = Turn::withTrashed()->rightJoin('cat_queues', 'cat_queues.id', 'turn.cat_queues_id')
                        ->whereNull('cat_queues.deleted_at')
                        ->selectRaw("cat_queues.id, max(turn.turn_at), CASE  WHEN max(turn.turn_at) is null THEN now()::TIMESTAMP + cat_queues.time_queues::INTERVAL ELSE max(turn.turn_at)::TIMESTAMP + cat_queues.time_queues::INTERVAL END  as time ")
                        ->groupBy('cat_queues.id', 'cat_queues.time_queues')
                        ->orderBy(DB::raw("CASE  WHEN max(turn.turn_at) is null THEN now()::TIMESTAMP + cat_queues.time_queues::INTERVAL ELSE max(turn.turn_at)::TIMESTAMP + cat_queues.time_queues::INTERVAL END"), 'ASC')
                        ->get();
                        
            $cat_id = $catQueue->id;

            /* Verificar la longitud del array de la consulta de tiempo estimado por cada cola */
            if (count($turns) > 0) {
                
                /* Buscar en el array como colección si existe un tiempo estimado que sea mayor al actual */
                $collection = collect($turns)->firstWhere('time', '>', $date);

                /* Verificar si las colas están vacías con respecto al tiempo calculado y consultado */
                if ($turns[0]->time < $date && ($collection == null && $turns[0]->max == null)) {

                    /* Consulta el último ticket de la cola con menos tiempo */
                    $ticket = Turn::withTrashed()->where('cat_queues_id', $cat_id)
                                ->whereDate('turn_at', $carbon->format('Y-m-d'))->max('ticket');

                    /* Calcula el tiempo de atención con la fecha actual */
                    $turn_at = $carbon->addMinutes(number_format($catQueue->time_queues)); 
                } else {
                    /* Es el caso de ya hay tickets entregados en las colas */
                    /* Se toma la cola con el menor tiempo de atención */
                    $cat_id = $turns[0]->id;

                    /* Consulta el último ticket de la cola con menos tiempo */
                    $ticket = Turn::withTrashed()->where('cat_queues_id', $cat_id)
                                ->whereDate('turn_at', $carbon->format('Y-m-d'))->max('ticket');

                    $select_queues = CatQueues::select(DB::raw("TO_NUMBER(TO_CHAR(time_queues::interval, 'MI'), '99G999D9S')  as time_queues")) 
                                    ->where('id', $cat_id)->first();

                    /* Si el tiempo es menor al actual, se asignará el actual; caso contrario el calculado en la consulta */
                    $turn_at = $turns[0]->time < $date ? $carbon->addMinutes(number_format($select_queues->time_queues)) : new Carbon($turns[0]->time);
                }

                /* Insertar turno */
                $turn = Turn::create([
                    'client_id' => $client->id,
                    'cat_queues_id' => $cat_id,
                    'ticket' => number_format($ticket + 1),
                    'turn_at' => $turn_at->format('Y-m-d H:i:s')
                ]);
            } else {
                /* Consulta el último ticket de la cola con menos tiempo */
                $ticket = Turn::withTrashed()->where('cat_queues_id', $catQueue->id)
                                ->whereDate('turn_at', $carbon->format('Y-m-d'))->max('ticket');

                /* Calcula el tiempo de atención con la fecha actual */
                $turn_at = $carbon->addMinutes(number_format($catQueue->time_queues)); 

                /* Insertar turno */
                $turn = Turn::create([
                    'client_id' => $client->id,
                    'cat_queues_id' => $cat_id,
                    'ticket' => number_format($ticket + 1),
                    'turn_at' => $turn_at->format('Y-m-d H:i:s')
                ]);
            }

            /* Hacer JOIN con la tabla de cola */
            $turn->load('catqueues');
            
            DB::commit();
            return response()->json(['status' => true, 'response' => 'Su ticket: Nº '.$turn->ticket.' Cola: '.$turn->catqueues->name ], 200);
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::write('TurnController', 'allTurn', $exception, 'Error');
            DB::rollBack();
            return response()->json(['status' => false, 'response' => $exception], 500);
        }
    }

    /**
     * Función para eliminar ticket una cola
     */
    protected static function deleteTurn($id) {
        try
        {
            Turn::where('id', $id)->delete();

            return true;
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::write('TurnController', 'deleteTurn', $exception, 'Error');

            return false;
        }
    }

    /**
     * Función para comparar los turnos y cambiar el status con delete lógico
     */
    protected static function verificacionTurno() {
        try
        {
            /* Fecha y Hora actual */
            $date = Date('Y-m-d H:i:s');
            $carbon = new Carbon($date);     

            /* Consulta de los 5 turnos próximos */       
            $turns = Turn::orderBy('turn_at','asc')->limit(5)->get();

            foreach($turns as $v):
                $comparar = new Carbon($v->turn_at);
                $seconds_diff= $carbon->diffInSeconds($comparar);
                /* Comparar la fecha actual con la fecha del turno */
                if ($seconds_diff <= 5 || $carbon >= $comparar) {
                    /* Delete lógico para marcar que ese ticket fue atentido */
                    static::deleteTurn($v->id);
                }
            endforeach;

            return true;
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::write('TurnController', 'deleteTurn', $exception, 'Error');

            return false;
        }
    }
}
