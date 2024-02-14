<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universidad extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'web',
        'logo',
        'estado',
        'is_disabled'
    ];
    protected $table = 'universidades';

    public function carreras()
    {
        return $this->hasMany(Carrera::class);
    }
}
