<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\util\Log;
use App\Models\CatQueues;
use Exception;

class CatQueuesController extends Controller
{
    /**
     * Función de conulta del Catálogo de Colas
     */
    public function allCatQueues(Request $request) {
        try
        {
            $queues = new CatQueues();
            if($request->get('name') != '' && $request->get('name') != null) {
                $queues = $queues->where('name', 'ilike', '%'.strtolower($request->get('name')).'%');
            }
            
            $queues = $queues->orderBy('name','asc');

            if ($request->get('row') != '' && $request->get('row') != null) {
                $queues =  $queues->paginate($request->get('row'));
            } else {
                $queues =  $queues->paginate(10);
            }
            

            return response()->json(['status' => true, 'response' => $queues ], 200);
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::write('CatQueuesController', 'allCatQueues', $exception, 'Error');

            return response()->json(['status' => false, 'response' => $exception], 500);
        }
    }

        /**
     * Función para insertar una nueva Cola
     */
    public function getByIdCatQueues(Request $request, $id) {
        try
        {
            $data = CatQueues::find($id);

            return response()->json(['status' => true, 'response' => $data ], 200);
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::write('CatQueuesController', 'getByIdCatQueues', $exception, 'Error');

            return response()->json(['status' => false, 'response' => $exception], 500);
        }
    }

    /**
     * Función para insertar una nueva Cola
     */
    public function insertCatQueues(Request $request) {
        try
        {
            $data = $request->json()->all();
            CatQueues::create(
                [
                    'name' => ucwords($data['name']),
                    'time_queues' => ($data['time_queues']),
                ]
            );

            return response()->json(['status' => true, 'response' => 'Creado con éxito' ], 200);
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::write('CatQueuesController', 'insertCatQueues', $exception, 'Error');

            return response()->json(['status' => false, 'response' => $exception], 500);
        }
    }

    /**
     * Función para editar una cola
     */
    public function updateCatQueues(Request $request, $id) {
        try
        {
            $data = $request->json()->all();
            CatQueues::where('id', $id)->update(
                [
                    'name' => ucwords($data['name']),
                    'time_queues' => ($data['time_queues']),
                ]
            );

            return response()->json(['status' => true, 'response' => 'Modificado con éxito' ], 200);
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::write('CatQueuesController', 'updateCatQueues', $exception, 'Error');

            return response()->json(['status' => false, 'response' => $exception], 500);
        }
    }

    /**
     * Función para eliminar lógicamente una cola
     */
    public function deleteCatQueues(Request $request, $id) {
        try
        {
            CatQueues::where('id', $id)->delete();

            return response()->json(['status' => true, 'response' => 'Eliminado con éxito' ], 200);
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::write('CatQueuesController', 'deleteCatQueues', $exception, 'Error');

            return response()->json(['status' => false, 'response' => $exception], 500);
        }
    }


}
