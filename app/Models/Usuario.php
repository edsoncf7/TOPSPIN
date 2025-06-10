<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'Usuario'; // Tu tabla personalizada

    protected $primaryKey = 'idUsuario';

    protected $fillable = [
        'nombreUsuario', 'email', 'contraseña'
    ];

    protected $hidden = [
        'contraseña', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->contraseña; // Nombre real de tu campo de contraseña
    }
}