<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'grado',
        'foto',
    ];

    protected $table = 'alumnos';

    protected $hidden = ['pivot'];

    public function profesores()
    {
        return $this->belongsToMany(Profesor::class, 'profesor_alumno', 'alumno_id', 'profesor_id');
    }
}

