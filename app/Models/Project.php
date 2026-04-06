<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     * Esto permite que el ProjectSeeder funcione sin errores de seguridad.
     */
protected $fillable = [
    'title',
    'category',
    'role',       
    'description',
    'stack',
    'url',   
    'logo'      
];

    /**
     * El stack tecnológico se guarda como un JSON en la base de datos.
     * Este cast lo convierte automáticamente en un array de PHP al usarlo en Blade.
     */
    protected $casts = [
        'stack' => 'array',
    ];
}