<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FormController extends Controller
{
    public function returnForm(){

        $campos = ['universidad' => ['nombre' => '', 'direccion' => '', 'telefono' => '', 'email' => '', 'web' => '', 'logo' => '', 'estado' => ''], 'carrera' => ['nombre' => '', 'descripcion' => '', 'creditos' => '', 'duracion' => '', 'certificada' => '', 'logo' => '', 'universidad' => ''], 'materia' => ['nombre' => '', 'carrera' => '', 'codigo' => '', 'descripcion' => '', 'creditos' => '', 'horas' => ''], 'profesor' => ['nombre' => '', 'apellido' => '', 'email' => '', 'telefono' => '', 'direccion' => '', 'foto' => '', 'campo' => ''], 'alumno' => ['nombre' => '', 'apellido' => '', 'email' => '', 'telefono' => '', 'direccion' => '', 'grado' => '', 'foto' => '', 'profesor' => '']];
        return Inertia::render('Add', ['campos' => $campos]);

    } 

    public function returnIndex(){
        return Inertia::render('Dashboard');
    }

    public function update(Request $request, $nivel){
        $campos = $request->all();
        return Inertia::render('modal', ['infoEdit' => $campos, 'nivel' => $nivel]);
    }
}
