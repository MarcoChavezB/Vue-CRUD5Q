<?php

namespace App\Http\Controllers;
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\ProfesorAlumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function getAlumnos($id){
        $profesor = Profesor::with(['alumnos' => function($query) {
            $query->select('foto', 'nombre', 'apellido', 'email', 'telefono', 'direccion', 'grado', 'alumnos.id')
            ->where('is_disabled', false);
        }, 'alumnos.profesores' => function($query) {
            $query->select('nombre');
        }])->find($id);

    
        $alumnos = $profesor->alumnos;
        return response()->json($alumnos);
    }

    public function deleteAlumno($id){
        $alumno = Alumno::find($id);
    
        $profesorAlumno = $alumno->profesorAlumno;
        $profesorId = $profesorAlumno ? $profesorAlumno->profesor_id : null;
        $alumno->is_disabled = true;
        $alumno->save();
        return response()->json(['message' => 'Alumno eliminado correctamente', 'id' => $profesorId]);
    }
    

    public function getAlumno($id){
        $alumno = Alumno::select('id','nombre', 'apellido', 'email', 'telefono', 'direccion', 'grado', 'foto')->find($id);

        if (!$alumno) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }

        return response()->json($alumno);
    }

    public function updateAlumno(Request $request){
        $data = $request->all();

        $this->validate($request, [
            'nombre' => 'min:3 | max:100 | nullable',
            'apellido' => 'min:3 | max:100 | nullable',
            'email' => 'email|nullable|unique:alumnos,email,' . $data['id'],
            'telefono' => 'min:9|max:13|nullable|unique:alumnos,telefono,' . $data['id'],
            'direccion' => 'min:3|max:100|nullable',
            'grado' => 'in:primero,segundo,tercero|nullable',
            'foto' => 'max:999 | nullable | url'
        ], [
                
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.max' => 'El nombre debe tener como maximo 100 caracteres',
    
                'apellido.min' => 'El apellido debe tener al menos 3 caracteres',
                'apellido.max' => 'El apellido debe tener como maximo 100 caracteres',
    
                'email.email' => 'El email no es valido',
                'email.unique' => 'El email ya esta en uso',
    
                'telefono.min' => 'El telefono debe tener al menos 9 caracteres',
                'telefono.max' => 'El telefono debe tener como maximo 13 caracteres',
                'telefono.unique' => 'El telefono ya esta en uso',
    
                'direccion.min' => 'La direccion debe tener al menos 3 caracteres',
                'direccion.max' => 'La direccion debe tener como maximo 100 caracteres',
    
                'grado.in' => 'El grado debe ser primero, segundo o tercero',

                'foto.max' => 'La foto debe tener como maximo 999 caracteres',
                'foto.url' => 'La foto debe ser una url valida',
        ]);      

        $alumno = Alumno::find($data['id']);

        if (!$alumno) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }
        
        if($alumno->nombre == $data['nombre'])

        $alumno->nombre = $data['nombre'] ?? $alumno->nombre;
        $alumno->apellido = $data['apellido'] ?? $alumno->apellido;
        $alumno->email = $data['email'] ?? $alumno->email;
        $alumno->telefono = $data['telefono'] ?? $alumno->telefono;
        $alumno->direccion = $data['direccion'] ?? $alumno->direccion;
        $alumno->grado = $data['grado'] ?? $alumno->grado;
        $alumno->save();

        return response()->json(['message' => 'Alumno actualizado correctamente'], 200);
    }

    public function store(Request $request){

        $this->validate($request, [
            'nombre' => 'required | min:3 | max:100',
            'apellido' => 'required | min:3 | max:100',
            'email' => 'required | email | unique:alumnos,email',
            'telefono' => 'required|unique:alumnos,telefono|integer|regex:/^[0-9]{9,13}$/',
            'direccion' => 'required | min:3 | max:100',
            'grado' => 'required | in:primero,segundo,tercero',
            'foto' => 'max:999 | nullable | url',
            'matricula' => 'required | min:5 | max:100 | exists:profesores,matricula',
            'profesor' => 'required | exists:profesores,nombre',
        ], [

            'nombre.required' => 'El nombre es requerido',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre debe tener como maximo 100 caracteres',
            'nombre.unique' => 'El nombre ya esta en uso',

            'apellido.required' => 'El apellido es requerido',
            'apellido.min' => 'El apellido debe tener al menos 3 caracteres',
            'apellido.max' => 'El apellido debe tener como maximo 100 caracteres',

            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es valido',
            'email.unique' => 'El email ya esta en uso',

            'telefono.required' => 'El telefono es requerido',
            'telefono.min' => 'El telefono debe tener al menos 9 caracteres',
            'telefono.max' => 'El telefono debe tener como maximo 13 caracteres',
            'telefono.unique' => 'El telefono ya esta en uso',
            'telefono.integer' => 'El telefono debe ser digitos',
            'telefono.regex' => 'El telefono no es valido',

            'direccion.required' => 'La direccion es requerida',
            'direccion.min' => 'La direccion debe tener al menos 3 caracteres',
            'direccion.max' => 'La direccion debe tener como maximo 100 caracteres',

            'grado.required' => 'El grado es requerido',
            'grado.in' => 'El grado no es valido (primero, segundo, tercero)',

            'profesor.required' => 'El profesor es requerido',
            'profesor.exists' => 'El profesor no existe',

            'foto.max' => 'La foto debe tener como maximo 999 caracteres',
            'foto.url' => 'La foto debe ser una url valida',

            'matricula.required' => 'La matricula es requerida',
            'matricula.min' => 'La matricula debe tener al menos 5 caracteres',
            'matricula.max' => 'La matricula debe tener como maximo 100 caracteres',
            'matricula.exists' => 'La matricula no existe',

        ]);


        $nombreProfesor = $request->input('profesor');

        $profesor = Profesor::where('nombre', $nombreProfesor)
                            ->where('matricula', $request->input('matricula'))
                            ->first();


        if ($profesor) {
            $nuevoAlumno = new Alumno();
            $nuevoAlumno->nombre = $request->input('nombre');
            $nuevoAlumno->apellido = $request->input('apellido');
            $nuevoAlumno->email = $request->input('email');
            $nuevoAlumno->telefono = $request->input('telefono');
            $nuevoAlumno->direccion = $request->input('direccion');
            $nuevoAlumno->grado = $request->input('grado');
            $nuevoAlumno->foto = $request->input('foto');

            $nuevoAlumno->save();
            
            $alumnoProfesor = new ProfesorAlumno();
            $alumnoProfesor->profesor_id = $profesor->id; 
            $alumnoProfesor->alumno_id = $nuevoAlumno->id; 

            $alumnoProfesor->save();

            $profesorId = $profesor->id;

            return response()->json(['message' => 'Alumno insertado correctamente', 'id' => $profesorId]);
        } else {
            return response()->json(['message' => 'La matricula no esta asociada a ningun profesor o no coincide con el nombre del profesor'], 404);
        }
    }

    public function agregarProfesor(Request $request)
    {
        $request->validate([
            'matricula' => 'required|string',
            'nombre' => 'required|string',
            'id_alumno' => 'required|exists:alumnos,id',
        ],[
            'matricula.required' => 'La matricula es requerida',
            'matricula.string' => 'La matricula debe ser un string',
            'nombre.required' => 'El nombre es requerido',
            'nombre.string' => 'El nombre debe ser un string',
            'id_alumno.required' => 'El id del alumno es requerido',
            'id_alumno.exists' => 'El id del alumno no existe',
        ]);
    
        $matricula = $request->input('matricula');
        $nombre = $request->input('nombre');
        $idAlumno = $request->input('id_alumno');
    
        $profesor = Profesor::where('matricula', $matricula)
            ->where('nombre', $nombre)
            ->first();
    
        if ($profesor) {
            $alumno = Alumno::findOrFail($idAlumno);
    
            if (!$alumno->profesores->contains($profesor)) {            
                $alumno->profesores()->attach($profesor->id);
                return response()->json(['message' => 'Profesor agregado correctamente al alumno']);
            } else {
                return response()->json(['message' => 'El profesor ya está asociado al alumno']);
            }
        } else {
            return response()->json(['message' => 'Profesor no encontrado'], 404);
        }        
    }


}
