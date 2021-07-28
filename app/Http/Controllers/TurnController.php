<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\util\Log;
use App\Models\Turn;
use App\Models\Client;
use App\Models\CatQueues;
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
            
            $client = Client::where('identification', 'ilike', strtolower($data['client']['identification']))->first();
            
            if (!isset($client)) {
                $client = Client::create(
                    [
                        'name' => ucwords($data['client']['name']),
                        'identification' => ($data['client']['identification']),
                    ]
                );

                if (!isset($client))
                    return response()->json(['status' => false, 'response' => 'No existe el cliente'], 400);
            }
           

            $turns = Turn::rightJoin('cat_queues', 'cat_queues.id', 'turn.cat_queues_id')
                        ->select('cat_queues.id as cat_queues_id', DB::raw("COUNT(turn.cat_queues_id) * TO_NUMBER(TO_CHAR(cat_queues.time_queues::interval, 'MI'),'99G999D9S') as time"))
                        ->groupBy('cat_queues.id', 'cat_queues.time_queues')
                        ->orderBy(DB::raw("COUNT(turn.*) * TO_NUMBER(TO_CHAR(cat_queues.time_queues::interval, 'MI'),'99G999D9S')"), 'ASC')
                        ->get();

            if (count($turns) > 0) {
                $ticket = Turn::where('cat_queues_id', $turns[0]->cat_queues_id)->max('ticket');

                $turn = Turn::create([
                    'client_id' => $client->id,
                    'cat_queues_id' => $turns[0]->cat_queues_id,
                    'ticket' => number_format($ticket + 1),
                ]);
            } else {
                $catQueues = CatQueues::orderBy('time_queues', 'ASC')->first();
                $turn = Turn::create([
                    'client_id' => $client->id,
                    'cat_queues_id' => $catQueues->id,
                    'ticket' => 1,
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
