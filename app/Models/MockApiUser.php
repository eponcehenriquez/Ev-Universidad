<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//Se agrega la clase JWTSubject
use Tymon\JWTAuth\Contracts\JWTSubject;

//Añade la implementacion JWTSubject al modelo User
class MockApiUser extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password'          => 'hashed',
    ];

    //Metodo que devuelve el identificador unico
    public function getJWTIdentifier()
    {
        //return $this->getKey();
        return "id";

    }

    //Metodo que devuelve un array en caso de querer incluir mas informacion en el token
    public function getJWTCustomClaims()
    {
        return [];
    }
}
