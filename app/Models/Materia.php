<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'creditos',
        'horas',
        'espacialidad',
        'carrera_id'
    ];
    protected $table = 'materias';


    protected $hidden = ['pivot'];
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function profesores()
    {
        return $this->belongsToMany(Profesor::class, 'materia_profesor', 'materia_id', 'profesor_id');
    }
    
}
