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
            $turns = new Turn();
            if($request->get('name') != '' && $request->get('name') != null) {
                $turns = $turns->where('name', 'ilike', '%'.strtolower($request->get('name')).'%');
            }
            
            $turns = $turns->orderBy('created_at','asc');

            if ($request->get('row') != '' && $request->get('row') != null) {
                $turns =  $turns->paginate($request->get('row'));
            } else {
                $turns =  $turns->paginate(10);
            }

            foreach ($turns as $t) :
                $t->load('catqueues', 'client');
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
            if (!isset($data['client'])) 
                return response()->json(['status' => false, 'response' => 'Falta los datos del cliente'], 400);
            
            $catQueue = CatQueues::select('id', DB::raw("TO_NUMBER(TO_CHAR(time_queues::interval, 'MI'), '99G999D9S')  as time_queues")) 
                                    ->orderBy('time_queues', 'ASC')->first();
            $client = Client::updateOrCreate(
                [
                    'identification' => ($data['client']['identification'])
                ],
                [
                    'name' => ucwords($data['client']['name']),
                    'identification' => ($data['client']['identification']),
                ]);
   

            if (!isset($client))
                return response()->json(['status' => false, 'response' => 'No existe el cliente'], 400);
           

            $date = Date('Y-m-d H:i:s');
            $carbon = new Carbon($date);            

            $turns = Turn::withTrashed()->rightJoin('cat_queues', 'cat_queues.id', 'turn.cat_queues_id')
                        ->selectRaw("cat_queues.id, max(turn.turn_at), CASE  WHEN max(turn.turn_at) is null THEN now()::TIMESTAMP + cat_queues.time_queues::INTERVAL ELSE max(turn.turn_at)::TIMESTAMP + cat_queues.time_queues::INTERVAL END  as time ")
                        ->groupBy('cat_queues.id', 'cat_queues.time_queues')
                        ->orderBy(DB::raw("CASE  WHEN max(turn.turn_at) is null THEN now()::TIMESTAMP + cat_queues.time_queues::INTERVAL ELSE max(turn.turn_at)::TIMESTAMP + cat_queues.time_queues::INTERVAL END"), 'ASC')
                        ->get();

            if (count($turns) > 0) {
                if ($turns[0]->time < $date) {
                    $ticket = Turn::withTrashed()->where('cat_queues_id', $catQueue->id)
                                ->whereDate('turn_at', $carbon->format('Y-m-d'))->max('ticket');
                    $turn_at = $carbon->addMinutes(number_format($catQueue->time_queues)); 
                } else {
                    $ticket = Turn::withTrashed()->where('cat_queues_id', $turns[0]->cat_queues_id)
                                ->whereDate('turn_at', $carbon->format('Y-m-d'))->max('ticket');
                    $turn_at = new Carbon($turns[0]->time);
                }

                $turn = Turn::create([
                    'client_id' => $client->id,
                    'cat_queues_id' => $turns[0]->id,
                    'ticket' => number_format($ticket + 1),
                    'turn_at' => $turn_at->format('Y-m-d H:i:s')
                ]);
            } else {
                $ticket = Turn::withTrashed()->where('cat_queues_id', $catQueue->id)
                                ->whereDate('turn_at', $carbon->format('Y-m-d'))->max('ticket');
                $turn_at = $carbon->addMinutes(number_format($catQueue->time_queues)); 

                $turn = Turn::create([
                    'client_id' => $client->id,
                    'cat_queues_id' => $turns[0]->id,
                    'ticket' => number_format($ticket + 1),
                    'turn_at' => $turn_at->format('Y-m-d H:i:s')
                ]);
            }
            
            DB::commit();
            return response()->json(['status' => true, 'response' => $turns ], 200);
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
    public function deleteTurn(Request $request, $id) {
        try
        {
            Turn::where('id', $id)->delete();

            return response()->json(['status' => true, 'response' => 'Eliminado con éxito' ], 200);
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::write('TurnController', 'deleteTurn', $exception, 'Error');

            return response()->json(['status' => false, 'response' => $exception], 500);
        }
    }
}
