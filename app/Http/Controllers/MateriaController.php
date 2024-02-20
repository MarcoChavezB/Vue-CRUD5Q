<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index(){
        $materias = Materia::select('nombre', 'descripcion', 'especialidad', 'creditos', 'horas', 'codigo','id')
        ->where('is_disabled', false) 
        ->get();

        return response()->json($materias);
    }

    public function getMaterias($id){
        $materia = Materia::select('nombre', 'descripcion', 'especialidad', 'creditos', 'horas', 'codigo','id')
        ->where('carrera_id', $id)
        ->where('is_disabled', false) 
        ->get();

        return response()->json($materia);
    }

    public function getMateria($id){
        $materia = Materia::select('id','nombre', 'descripcion', 'especialidad', 'horas', 'creditos', 'codigo')->find($id);

        return response()->json($materia);
    }

    public function deleteMateria($id){
        $materia = Materia::find($id);

        if (!$materia) {
            return response()->json(['message' => 'Materia no encontrada'], 404);
        }

        $materia->is_disabled = true;
        $materia->save();
        return response()->json(['message' => 'Materia eliminada correctamente']);
    }

    public function updateMateria(Request $request){
        $data = $request->all();

        $this->validate($request, [
            'nombre' => 'min:3 | max:100 | nullable',
            'descripcion' => 'min:3 | max:100 | nullable',
            'especialidad' => 'min:3 | max:100 | nullable | in:programacion,diseño,redes,base de datos',
            'horas' => 'integer | between:30,50 | nullable',
            'creditos' => 'integer | between:100,500 | nullable',
            'codigo' => 'min:3 | max:100 | nullable | unique:materias,codigo,' . $data['id'],
        ], [
                
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.max' => 'El nombre debe tener como maximo 100 caracteres',
                
                'descripcion.min' => 'La descripcion debe tener al menos 3 caracteres',
                'descripcion.max' => 'La descripcion debe tener como maximo 100 caracteres',
    
                'especialidad.min' => 'La especialidad debe tener al menos 3 caracteres',
                'especialidad.max' => 'La especialidad debe tener como maximo 100 caracteres',
                'especialidad.in' => 'La especialidad debe ser programacion, diseño, redes o base de datos',
    
                'horas.integer' => 'Las horas deben ser un numero entero',
                'horas.between' => 'Las horas deben ser entre 30 y 50',
    
                'creditos.integer' => 'Los creditos deben ser un numero entero',
                'creditos.between' => 'Los creditos deben ser entre 100 y 500',
    
                'codigo.min' => 'El codigo debe tener al menos 3 caracteres',
                'codigo.max' => 'El codigo debe tener como maximo 100 caracteres',
        ]);

        $materia = Materia::find($data['id']);

        // no se encontro
        if (!$materia) {
            return response()->json(['message' => 'Materia no encontrada'], 404);
        }

        // no se realizarion cambios
        if($materia->nombre == $data['nombre'] && $materia->descripcion == $data['descripcion'] && $materia->especialidad == $data['especialidad'] && $materia->horas == $data['horas'] && $materia->creditos == $data['creditos'] && $materia->codigo == $data['codigo']){
            return response()->json(['message' => 'No se realizaron cambios']);
        }

        $materia->nombre = $data['nombre'] ?? $materia->nombre;
        $materia->descripcion = $data['descripcion'] ?? $materia->descripcion;
        $materia->especialidad = $data['especialidad'] ?? $materia->especialidad;
        $materia->horas = $data['horas'] ?? $materia->horas;
        $materia->creditos = $data['creditos'] ?? $materia->creditos;
        $materia->save();

        return response()->json(['message' => 'Materia actualizada correctamente'], 200);
    }

    // materias y logramos hacer eso 

    public function createMateria(Request $request){

        $this->validate($request, [
            'nombre' => 'required | min:3 | max:100 | unique:materias,nombre',
            'carrera' => 'required | exists:carreras,nombre',
            'codigo' => 'required | min:3 | max:10 | unique:materias,codigo',
            'especialidad' => 'required | min:3 | max:100 | in:programacion,diseño,redes,base de datos',
            'descripcion' => 'required | min:3 | max:100',
            'creditos' => 'required | integer | between:100,500',
            'horas' => 'required | integer | between:30,50 ',
        ], [

            'nombre.required' => 'El nombre es requerido',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre debe tener como maximo 100 caracteres',
            'nombre.unique' => 'El nombre ya esta en uso',

            'carrera.required' => 'La carrera es requerida',
            'carrera.exists' => 'La carrera no existe',
            'carrera.max' => 'La carrera debe tener como maximo 100 caracteres',
            
            'codigo.required' => 'El codigo es requerido',
            'codigo.min' => 'El codigo debe tener al menos 3 caracteres',
            'codigo.max' => 'El codigo debe tener como maximo 10 caracteres',
            'codigo.unique' => 'El codigo ya esta en uso',

            'especialidad.required' => 'La especialidad es requerida',
            'especialidad.min' => 'La especialidad debe tener al menos 3 caracteres',
            'especialidad.max' => 'La especialidad debe tener como maximo 100 caracteres',
            'especialidad.in' => 'La especialidad debe ser programacion, diseño, redes o base de datos',

            'descripcion.required' => 'La descripcion es requerida',
            'descripcion.min' => 'La descripcion debe tener al menos 3 caracteres',
            'descripcion.max' => 'La descripcion debe tener como maximo 100 caracteres',
            
            'creditos.required' => 'Los creditos son requeridos',
            'creditos.integer' => 'Los creditos deben ser un numero entero',
            'creditos.between' => 'Los creditos deben ser entre 100 y 500',

            'horas.required' => 'Las horas son requeridas',
            'horas.integer' => 'Las horas deben ser un numero entero',
            'horas.between' => 'Las horas deben ser entre 30 y 50',
        ]);

        $nombreCarrera = $request->input('carrera');
        $carrera = Carrera::where('nombre', $nombreCarrera)->first();

        if ($carrera) {
            $nuevaMateria = new Materia();
            $nuevaMateria->nombre = $request->input('nombre');
            $nuevaMateria->descripcion = $request->input('descripcion');
            $nuevaMateria->codigo = $request->input('codigo');
            $nuevaMateria->especialidad = $request->input('especialidad');
            $nuevaMateria->horas = $request->input('horas');
            $nuevaMateria->creditos = $request->input('creditos');
            $nuevaMateria->carrera_id = $carrera->id;

            $nuevaMateria->save();

            return response()->json(['message' => 'Materia insertada correctamente', 'id' => $carrera->id]);
        } else {
            return response()->json(['message' => 'La carrera no existe']);
        }
    }
}
