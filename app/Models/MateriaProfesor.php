<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaProfesor extends Model
{
    use HasFactory;
    protected $fillable = [
        'profesor_id',
        'materia_id'
    ];
    protected $table = 'materia_profesor';

}
