<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewUser extends Model
{
    protected $table = 'new_user';
    protected $fillable = ['nombres', 'apellidos', 'rut', 'email', 'direccion', 'telefono1', 'telefono2', 'fechnac', 'password', 'estado', 'tipo'];
    
    public $timestaps = true;
}
