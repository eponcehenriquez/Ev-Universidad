<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\MockApiUserServices;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class MockApiUserProvider implements UserProvider
{
    protected $apiUrl = 'https://653040df6c756603295e7806.mockapi.io/v1/users';
    public $id;

    //Retorna la url de conexión
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    //Buscar en api por ID
    public function retrieveById($id)
    {
        $response = Http::get("{$this->apiUrl}/{$id}");
        if ($response->successful()) {
            return new MockApiUserServices($response->json());
        }
        return null;
    }

    //Obtine las credenciales a partir del email ingresado
    public function retrieveByCredentials(array $credentials)
    {
        $email = urlencode($credentials['email']);
        $response = Http::get("{$this->apiUrl}?email={$email}");
        $users = $response->json();
        if (count($users) > 0) {
            return new MockApiUserServices($users[0]); 
        }
        return null;
    }

    //Verifica si la contraseña ingresada coicide con la registrada en el endpoint
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return Hash::check($credentials['password'], $user->getAuthPassword());
    }

    

    public function retrieveByToken($identifier, $token)
    {
        // No se utiliza
        // Se declara para evitar errores de implementación con UserProvider 
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // No se utiliza
        // Se declara para evitar errores de implementación con UserProvider 
    }
}


