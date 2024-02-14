<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'creditos',
        'duracion',
        'certificada',
        'logo',
        'universidad_id'
    ];
    protected $table = 'carreras';

    public function universidad()
    {
        return $this->belongsTo(Universidad::class);
    }

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }
}
