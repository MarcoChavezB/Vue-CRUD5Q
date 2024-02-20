<?php

namespace App\Http\Controllers;

use App\Models\Universidad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UniversidadController extends Controller
{
    public function index()
    {
        $universidades = Universidad::select('logo', 'nombre', 'telefono', 'email', 'direccion', 'web', 'id')
            ->where('is_disabled', false) 
            ->get();
    
        return response()->json($universidades);
    }

    public function returnTable(){
        return Inertia::render('indexTable');
    }
    
    public function getUniversidad($id){
        $universidad = Universidad::select('id','nombre', 'telefono', 'email', 'direccion', 'web', 'logo')
            ->where('is_disabled', false)   
            ->find($id);
        return response()->json($universidad);
    }


    public function deleteUniversidad($id){
        $universidad = Universidad::find($id);

        if (!$universidad) {
            return response()->json(['message' => 'Universidad no encontrada'], 404);
        }

        $universidad->is_disabled = true;
        $universidad->save();
        return response()->json(['message' => 'Universidad eliminada correctamente']);
    }

    public function updateUniversidad(Request $request){

        $data = $request->all();

        $this->validate($request, [
            'nombre' => 'min:3 | max:100 | nullable',
            'telefono' => 'min:9|max:13|nullable|unique:universidades,telefono,' . $data['id'],
            'direccion' => 'min:3 | max:100 | nullable',
            'email' => 'email | nullable | unique:universidades,email,' . $data['id'],
            'web' => 'required | url | nullable | unique:universidades,web,' . $data['id'],
            'logo' => 'max:999 | nullable | url',
        ], [

            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre debe tener como maximo 100 caracteres',
           
            'direccion.min' => 'La direccion debe tener al menos 3 caracteres',
            'direccion.max' => 'La direccion debe tener como maximo 100 caracteres',

            'telefono.min' => 'El telefono debe tener al menos 9 caracteres',
            'telefono.max' => 'El telefono debe tener como maximo 13 caracteres',
            'telefono.unique' => 'El telefono ya esta en uso',

            'email.email' => 'El email no es valido',
            'email.unique' => 'El email ya esta en uso',

            'web.required' => 'La web es requerida',
            'web.unique' => 'La web ya esta en uso',
            'web.url' => 'La web no es valida, debe ser una url valida',

            'logo.max' => 'El logo debe tener como maximo 999 caracteres',
            'logo.url' => 'El logo no es valido, debe ser una url valida',
        ]);

        $universidad = Universidad::find($data['id']);

        if (!$universidad) {
            return response()->json(['message' => 'Universidad no encontrada'], 404);
        }

        if ($universidad->nombre == $data['nombre'] && $universidad->telefono == $data['telefono'] && $universidad->direccion == $data['direccion'] && $universidad->email == $data['email'] && $universidad->web == $data['web'] && $universidad->logo == $data['logo']) {
            return response()->json(['message' => 'No se realizo ningun cambio'], 304);
        }


        $universidad->nombre = $data['nombre'] ?? $universidad->nombre;
        $universidad->telefono = $data['telefono'] ?? $universidad->telefono;
        $universidad->email = $data['email'] ?? $universidad->email;
        $universidad->direccion = $data['direccion'] ?? $universidad->direccion;
        $universidad->web = $data['web'] ?? $universidad->web;
        $universidad->save();

        return response()->json(['message' => 'Universidad actualizada correctamente']);
    }






    public function createUniversidad(Request $request){
        $data = $request->all();


        $this->validate($request, [
            'nombre' => 'required | min:3 | max:100',
            'direccion' => 'required | min:3 | max:100',
            'telefono' => 'required | min:9 | max:13 | unique:universidades,telefono',
            'email' => 'required | email | unique:universidades,email',
            'web' => 'required',
            'estado' => 'required | in:activo,inactivo',
        ],[
            'nombre.required' => 'El nombre es requerido',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre debe tener como maximo 100 caracteres',
           
            'direccion.required' => 'La direccion es requerida',
            'direccion.min' => 'La direccion debe tener al menos 3 caracteres',
            'direccion.max' => 'La direccion debe tener como maximo 100 caracteres',

            'telefono.required' => 'El telefono es requerido',
            'telefono.min' => 'El telefono debe tener al menos 9 caracteres',
            'telefono.max' => 'El telefono debe tener como maximo 13 caracteres',
            'telefono.unique' => 'El telefono ya esta en uso',

            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es valido',
            'email.unique' => 'El email ya esta en uso',

            'estado.required' => 'El estado es requerido',
            'estado.in' => 'El estado debe ser activo o inactivo',

            'web.required' => 'La web es requerida',
        ]);

        $universidad = new Universidad();
        $universidad->nombre = $data['nombre'];
        $universidad->direccion = $data['direccion'];
        $universidad->telefono = $data['telefono'];
        $universidad->email = $data['email'];
        $universidad->web = $data['web'];
        $universidad->logo = $data['logo'];
        $universidad->logo = $data['estado'] ?? 1;
        $universidad->save();

        return response()->json(['message' => 'Universidad creada correctamente']);
    }
}
