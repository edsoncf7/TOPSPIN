<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'Usuario'; // ← nombre EXACTO de tu tabla

    protected $primaryKey = 'idUsuario';

    public $timestamps = false;

    protected $fillable = [
        'nombreUsuario',
        'email',
        'contraseña',
        'idCargoUsuario'
    ];

    protected $hidden = [
        'contraseña',
    ];

    // Laravel espera "password", así que redireccionamos
    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}