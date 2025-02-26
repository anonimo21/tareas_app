<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualizarTareaRequest;
use App\Http\Requests\GuardarTareaRequest;
use App\Http\Resources\TareaResource;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        return TareaResource::collection(Tarea::all());
    }

    public function store(GuardarTareaRequest $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'estado' => 'required'
        ]);
        return (new TareaResource(Tarea::create($request->all())))->additional(['msg' => 'Tarea guardada con exito!']);
    }

    public function show(Tarea $tarea)
    {
        return new TareaResource($tarea);
    }


    public function update(ActualizarTareaRequest $request, Tarea $tarea)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'estado' => 'required'
        ]);
        $tarea->update($request->all());
        return (new TareaResource($tarea))
            ->additional(['msg' => 'Tarea actualizado con exito'])
            ->response()
            ->setStatusCode(202);
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return (new TareaResource($tarea))
            ->additional(['msg' => 'Tarea eliminado con exito']);
    }

    public function getTasks()
    {
        $tasks = DB::table('tareas')
            ->select('id', 'nombre', 'descripcion', 'estado')
            ->get();
        return $tasks;
    }
}
