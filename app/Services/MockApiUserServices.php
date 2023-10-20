<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class MockApiUserServices implements Authenticatable, JWTSubject
{
    protected $attributes;
    public $id;

    public function __construct(array $attributes)
    {
        $this->attributes   = $attributes;
        $this->id           = $attributes['id'];
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['id'];
    }

    //Verifica la contraseña almacenada con la contraseña ingresada
    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    //Genera el token
    public function getJWTIdentifier()
    {
        return $this->getAuthIdentifier();
    }

    //Función que puede agregar campos extras al token (roles, usuarios, etc)
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getRememberToken()
    {
        // No se utiliza
        // Se declara para evitar errores de implementación con Authenticatable, JWTSubject 
    }

    public function setRememberToken($value)
    {
        // No se utiliza
        // Se declara para evitar errores de implementación con Authenticatable, JWTSubject 
    }

    public function getRememberTokenName()
    {
        // No se utiliza
        // Se declara para evitar errores de implementación con Authenticatable, JWTSubject 
    }

    
}
