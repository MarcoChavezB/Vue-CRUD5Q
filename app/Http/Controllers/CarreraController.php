<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Universidad;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function getCarrera($id){
        $carrera = Carrera::select('logo', 'nombre', 'descripcion', 'duracion', 'creditos', 'certificada', 'id')
        ->where('is_disabled', false) 
        ->where('universidad_id', $id)->get();
        return response()->json($carrera);
    }

    public function getCarreras($id){
        $carrera = Carrera::select('id','nombre', 'descripcion', 'duracion', 'creditos', 'certificada', 'logo')->find($id);
        return response()->json($carrera);
    }

    public function deleteCarrera ($id){
        $carrera = Carrera::find($id);

        if ($carrera->is_disabled) {
            return response()->json(['message' => 'La carrera ya esta eliminada']);
        }

        $carrera->is_disabled = true;
        $carrera->save();
        return response()->json(['message' => 'Carrera eliminada correctamente']);
    }

    public function updateCarrera(Request $request){
        $data = $request->all();

        $this->validate($request, [
            'nombre' => 'min:3 | max:100 | nullable',
            'descripcion' => 'min:10 | max:100 | nullable',
            'duracion' => 'integer | between:30,50 | nullable',
            'creditos' => 'integer | between:100,500 | nullable',
            'certificada' => 'between:0,1 | nullable',
            'logo' => 'max:999 | nullable | url',
        ], [

            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre debe tener como maximo 100 caracteres',
           
            'descripcion.min' => 'La descripcion debe tener al menos 10 caracteres',
            'descripcion.max' => 'La descripcion debe tener como maximo 100 caracteres',

            'duracion.integer' => 'La duracion debe ser un numero entero',
            'duracion.between' => 'La duracion debe ser entre 30 y 50',

            'creditos.integer' => 'Los creditos deben ser un numero entero',
            'creditos.between' => 'Los creditos deben ser entre 100 y 500',

            'certificada.in' => 'La certificacion debe ser 1 o 0',

            'logo.max' => 'El logo debe tener como maximo 999 caracteres',
            'logo.url' => 'El logo debe ser una url valida',

        ]);

        $carrera = Carrera::find($data['id']);

        if (!$carrera) {
            return response()->json(['message' => 'Carrera no encontrada'], 404);
        }

        if ($carrera->nombre == $data['nombre'] && $carrera->descripcion == $data['descripcion'] && $carrera->duracion == $data['duracion'] && $carrera->creditos == $data['creditos'] && $carrera->certificada == $data['certificada'] && $carrera->logo == $data['logo']) {
            return response()->json(['message' => 'No se realizo ningun cambio']);
        }


        $carrera->nombre = $data['nombre'] ?? $carrera->nombre;
        $carrera->descripcion = $data['descripcion'] ?? $carrera->descripcion;
        $carrera->duracion = $data['duracion'] ?? $carrera->duracion;
        $carrera->creditos = $data['creditos'] ?? $carrera->creditos;
        $carrera->certificada = $data['certificada'] ?? $carrera->certificada;
        $carrera->save();

        return response()->json(['message' => 'Carrera actualizada correctamente']);
    }




    public function createCarrera(Request $request){

    $nombreUniversidad = $request->input('universidad');
    $universidad = Universidad::where('nombre', $nombreUniversidad)->first();

    $this->validate($request, [
        'nombre' => 'required | min:3 | max:100 | unique:carreras,nombre',
        'descripcion' => 'required | min:3 | max:100',
        'creditos' => 'required|integer|between:100,500',
        'duracion' => 'required|integer|between:30,50',
        'certificada' => 'required | in:0,1',
        'universidad' => 'required | exists:universidades,nombre',

    ], [
        'nombre.required' => 'El nombre es requerido',
        'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
        'nombre.max' => 'El nombre debe tener como maximo 100 caracteres',
        'nombre.unique' => 'La carrera ya existe',

        'descripcion.required' => 'La descripcion es requerida',
        'descripcion.min' => 'La descripcion debe tener al menos 3 caracteres',
        'descripcion.max' => 'La descripcion debe tnoener como maximo 100 caracteres',

        'creditos.required' => 'Los creditos son requeridos',
        'creditos.integer' => 'Los creditos deben ser un numero entero',
        'creditos.between' => 'Los creditos deben ser entre 100 y 500',

        'duracion.required' => 'La duracion es requerida',
        'duracion.integer' => 'La duracion debe ser un numero entero',
        'duracion.min' => 'La duracion debe ser mayor a 30',
        'duracion.max' => 'La duracion debe ser menor a 50',
        'duracion.between' => 'La duracion debe ser entre 30 y 50',

        'certificada.required' => 'La certificacion es requerida',
        'certificada.in' => 'La certificacion debe ser 1 (certificada) o 0 (no certificada)',

        'universidad.required' => 'La universidad es requerida',
        'universidad.exists' => 'La universidad no existe',

    ]);

    if ($universidad) {
        $nuevaCarrera = new Carrera();
        $nuevaCarrera->nombre = $request->input('nombre');
        $nuevaCarrera->descripcion = $request->input('descripcion');
        $nuevaCarrera->creditos = $request->input('creditos');
        $nuevaCarrera->duracion = $request->input('duracion');
        $nuevaCarrera->certificada = $request->input('certificada');
        $nuevaCarrera->logo = $request->input('logo');
        $nuevaCarrera->universidad_id = $universidad->id;

        $nuevaCarrera->save();

        return response()->json(['message' => 'Carrera insertada correctamente', 'id' => $universidad->id]);
    } else {
        return response()->json(['message' => 'La universidad no existe']);
    }
    }
}
