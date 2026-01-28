<?php
 
namespace App\Http\Controllers;
 
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 
class EventoController extends Controller
{
    /**
     * GET /eventos
     */
    public function index()
    {
        $eventos = Evento::all();
 
        return response()->json([
            'eventos' => $eventos,
            'status'  => 200,
        ], 200);
    }
 
    /**
     * POST /eventos
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'ubicacion'    => 'required|string|max:255',
        ]);
 
        // Si la petición no contiene todos los datos necesarios, retornar error
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors(),
                'status'  => 400,
            ], 400);
        }
 
        $evento = Evento::create([
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'ubicacion'    => $request->ubicacion,
        ]);
 
        if (!$evento) {
            return response()->json([
                'message' => 'Error al crear el evento',
                'status'  => 500,
            ], 500);
        }
 
        return response()->json([
            'evento' => $evento,
            'status' => 201,
        ], 201);
    }
 
    /**
     * GET /eventos/{id}
     */
    public function show($id)
    {
        $evento = Evento::find($id);
 
        if (!$evento) {
            return response()->json([
                'message' => 'Evento no encontrado',
                'status'  => 404,
            ], 404);
        }
 
        return response()->json([
            'evento' => $evento,
            'status' => 200,
        ], 200);
    }
 
    /**
     * PUT/PATCH /eventos/{id}
     */
    public function update(Request $request, $id)
    {
        $evento = Evento::find($id);
 
        if (!$evento) {
            return response()->json([
                'message' => 'Evento no encontrado',
                'status'  => 404,
            ], 404);
        }
 
        $validator = Validator::make($request->all(), [
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'ubicacion'    => 'required|string|max:255',
        ]);
 
        // Si la petición no contiene todos los datos necesarios, retornar error
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors(),
                'status'  => 400,
            ], 400);
        }
 
        $evento->titulo       = $request->titulo;
        $evento->descripcion  = $request->descripcion;
        $evento->fecha_inicio = $request->fecha_inicio;
        $evento->fecha_fin    = $request->fecha_fin;
        $evento->ubicacion    = $request->ubicacion;
        $evento->save();
 
        return response()->json([
            'evento' => $evento,
            'status' => 200,
        ], 200);
    }
 
    /**
     * DELETE /eventos/{id}
     */
    public function destroy($id)
    {
        $evento = Evento::find($id);
 
        if (!$evento) {
            return response()->json([
                'message' => 'Evento no encontrado',
                'status'  => 404,
            ], 404);
        }
 
        $evento->delete();
 
        return response()->json([
            'message' => 'Evento eliminado',
            'status'  => 200,
        ], 200);
    }
}
 