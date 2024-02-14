<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorAlumno extends Model
{
    protected $fillable = [
        'profesor_id',
        'alumno_id'
    ];
    protected $table = 'profesor_alumno';

}
