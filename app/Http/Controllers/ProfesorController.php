<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\MateriaProfesor;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function getProfesores($id){
        $materia = Materia::with(['profesores' => function ($query) {
            $query->select('foto', 'nombre', 'apellido', 'email', 'telefono', 'direccion', 'campo', 'matricula', 'profesores.id')
                ->where('is_disabled', false)
                ->with(['materias' => function ($innerQuery) {
                    $innerQuery->select('nombre');
                }]);
        }])->find($id);        
    
        $profesores = $materia->profesores;
        return response()->json($profesores);
    }
    

    public function getProfesor($id){
        $profesor = Profesor::select('id', 'nombre', 'apellido', 'email', 'telefono', 'direccion','campo','matricula','foto')->find($id);
        return response()->json($profesor);
    }


    public function deleteProfesor($id){
        $profesor = Profesor::find($id);
    
        if (!$profesor) {
            return response()->json(['message' => 'Profesor no encontrado'], 404);
        }
        $profesorMateria = $profesor->profesorMateria; 
        $materiaId = $profesorMateria ? $profesorMateria->materia_id : null;
        $profesor->is_disabled = true;
        $profesor->save();
        return response()->json(['message' => 'Profesor eliminado correctamente', 'id' => $materiaId]);
    }

    public function updateProfesor(Request $request){
        $data = $request->all();

        $this->validate($request, [
            'nombre'    => 'min:3 | max:100 | nullable',
            'apellido'  => 'min:3 | max:100 | nullable',
            'email'     => 'email|nullable|unique:profesores,email,' . $data['id'],
            'telefono'  => 'min:9|max:13|nullable|unique:profesores,telefono,' . $data['id'],
            'direccion' => 'min:3|max:100|nullable',
            'campo'     => 'in:programacion,diseño,redes,base de datos|nullable',
            'matricula' => 'min:5|max:100|nullable|unique:profesores,matricula,' . $data['id'],
            'foto'      => 'max:999 | nullable | url'
        ], [

            'nombre.min'        => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max'        => 'El nombre debe tener como maximo 100 caracteres',

            'apellido.min'      => 'El apellido debe tener al menos 3 caracteres',
            'apellido.max'      => 'El apellido debe tener como maximo 100 caracteres',

            'email.email'       => 'El email no es valido',
            'email.unique'      => 'El email ya esta en uso',

            'telefono.min'      => 'El telefono debe tener al menos 9 caracteres',
            'telefono.max'      => 'El telefono debe tener como maximo 13 caracteres',
            'telefono.unique'   => 'El telefono ya esta en uso',

            'direccion.min'     => 'La direccion debe tener al menos 3 caracteres',
            'direccion.max'     => 'La direccion debe tener como maximo 100 caracteres',

            'campo.in'          => 'El campo debe ser programacion, diseño, redes o base de datos',

            'matricula.min'     => 'La matricula debe tener al menos 3 caracteres',
            'matricula.max'     => 'La matricula debe tener como maximo 100 caracteres',
            'matricula.unique'  => 'La matricula ya esta en uso',

            'foto.max'          => 'La foto debe tener como maximo 999 caracteres',
            'foto.url'          => 'La foto no es valida, debe ser una url valida',

        ]);

        $profesor = Profesor::find($data['id']);
        $profesor->nombre = $data['nombre'] ?? $profesor->nombre;
        $profesor->apellido = $data['apellido'] ?? $profesor->apellido;
        $profesor->email = $data['email'] ?? $profesor->email;
        $profesor->telefono = $data['telefono'] ?? $profesor->telefono;
        $profesor->direccion = $data['direccion'] ?? $profesor->direccion;
        $profesor->matricula = $data['matricula'] ?? $profesor->matricula;
        $profesor->campo = $data['campo'] ?? $profesor->campo;
        $profesor->save();

        return response()->json(['message' => 'Profesor actualizado correctamente']);
    }

    public function createProfesor(Request $request){

        $this->validate($request, [
            'nombre' => 'required | min:3 | max:100',
            'apellido' => 'required | min:3 | max:100',
            'email' => 'required | email | unique:profesores,email',
            'telefono' => 'required | min:9 | max:13 | unique:profesores,telefono',
            'direccion' => 'required | min:3 | max:100',
            'matricula' => 'required | min:5 | max:100',
            'materia' => 'required | exists:materias,nombre',
            'campo' => 'required | in:programacion,diseño,redes,base de datos', 
        ], [    

            'nombre.required' => 'El nombre es requerido',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre debe tener como maximo 100 caracteres',
            'nombre.unique' => 'El nombre ya esta en uso',

            'apellido.required' => 'El apellido es requerido',
            'apellido.min' => 'El apellido debe tener al menos 3 caracteres',
            'apellido.max' => 'El apellido debe tener como maximo 100 caracteres',
            'apellido.unique' => 'El apellido ya esta en uso',

            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es valido',
            'email.unique' => 'El email ya esta en uso',

            'telefono.required' => 'El telefono es requerido',
            'telefono.min' => 'El telefono debe tener al menos 9 caracteres',
            'telefono.max' => 'El telefono debe tener como maximo 13 caracteres',
            'telefono.unique' => 'El telefono ya esta en uso',

            'direccion.required' => 'La direccion es requerida',
            'direccion.min' => 'La direccion debe tener al menos 3 caracteres',
            'direccion.max' => 'La direccion debe tener como maximo 100 caracteres',

            'foto.required' => 'La foto es requerida',

            'matricula.required' => 'La matricula es requerida',
            'matricula.min' => 'La matricula debe tener al menos 3 caracteres',
            'matricula.max' => 'La matricula debe tener como maximo 100 caracteres',
            'matricula.unique' => 'La matricula ya esta en uso',

            'materia.required' => 'La materia es requerida',
            'materia.exists' => 'La materia no existe',
            'materia.max' => 'La materia debe tener como maximo 100 caracteres',

            'campo.required' => 'El campo es requerido',
            'campo.in' => 'El campo debe ser programacion, diseño, redes o base de datos',

        ]);

        $nombreMateria = $request->input('materia');
        $materia = Materia::where('nombre', $nombreMateria)->first();
    
        if ($materia) {
            $nuevoProfesor = new Profesor();
            $nuevoProfesor->nombre = $request->input('nombre');
            $nuevoProfesor->apellido = $request->input('apellido');
            $nuevoProfesor->email = $request->input('email');
            $nuevoProfesor->telefono = $request->input('telefono');
            $nuevoProfesor->direccion = $request->input('direccion');
            $nuevoProfesor->campo = $request->input('campo');
            $nuevoProfesor->matricula = $request->input('matricula');
            $nuevoProfesor->foto = $request->input('foto');
            
            $nuevoProfesor->save();
            
            $materiaProfesores = new MateriaProfesor();
            $materiaProfesores->materia_id = $materia->id;
            $materiaProfesores->profesor_id = $nuevoProfesor->id;
            $materiaProfesores->save();

            $materiaId = $materia->id;
    
            return response()->json(['message' => 'Profesor insertado correctamente', 'id' => $materiaId]);

        } else {
            return response()->json(['message' => 'La materia no existe']);
        }
    }

public function agregarMateria(Request $request)
{
    $this->validate($request, [
        'nombre' => 'required|exists:materias,nombre|max:100',
        'codigo' => 'required|max:100',
        'id_profesor' => 'required|exists:profesores,id|max:100',
    ], [
  
        'nombre.required' => 'El nombre de la materia es requerido',
        'nombre.exists' => 'La materia no existe',
        'nombre.max' => 'El nombre de la materia debe tener como máximo 100 caracteres',

        'codigo.required' => 'El código de la materia es requerido',
        'codigo.max' => 'El código de la materia debe tener como máximo 100 caracteres',

        'id_profesor.required' => 'El ID del profesor es requerido',
        'id_profesor.exists' => 'El profesor no existe',
        'id_profesor.max' => 'El ID del profesor debe tener como máximo 100 caracteres',
  
    ]);

    $nombreMateria = $request->input('nombre');
    $codigoMateria = $request->input('codigo');
    $idProfesor = $request->input('id_profesor');

    $materia = Materia::where('nombre', $nombreMateria)
        ->where('codigo', $codigoMateria)
        ->first();

    if ($materia) {
        $profesor = Profesor::find($idProfesor);

        if (!$profesor->materias->contains($materia->id)) {
            $profesor->materias()->attach($materia->id);
            return response()->json(['message' => 'Materia asignada correctamente al profesor']);
        } else {
            return response()->json(['message' => 'El profesor ya tiene asignada esta materia']);
        }
    } else {
        return response()->json(['message' => 'La materia no existe']);
    }
}

    
}
