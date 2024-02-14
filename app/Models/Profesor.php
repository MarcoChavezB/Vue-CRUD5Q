<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'foto'
    ];


    protected $hidden = ['pivot'];

    protected $table = 'profesores';

    public function materias()
    {
        return $this->belongsToMany(Materia::class);
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'profesor_alumno', 'profesor_id', 'alumno_id');
    }
}
