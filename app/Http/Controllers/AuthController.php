<?php

namespace App\Http\Controllers;

use App\Models\MockApiUser;
use Illuminate\Http\Request;
use Carbon\Exceptions\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\MockApiUserServices;
use App\Providers\MockApiUserProvider;
use App\Http\Requests\RegistrarUsuarioRequest;

class AuthController extends Controller
{
    protected $userProvider;


    public function __construct(MockApiUserProvider $userProvider)
    {
        //Se aplica el middleware de autenticación a todos los metodos excepto login y register
        $this->middleware('auth:api', ['except' => ['login', 'new']]);
        $this->userProvider = $userProvider;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $token = auth()->attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'No Autorizado'], 401);
        }

        return $this->generarJsonToken($token);
    }

    public function new(RegistrarUsuarioRequest $request)
    {  
        $url = $this->userProvider->getApiUrl();

        $response = Http::post($url, [
            'nombre'    => $request->nombre,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
        ]);

        if ($response->successful()) {
            // Se convierte el array a una instancia del modelo MockApiUser
            $usuario = new MockApiUserServices($response->json());
            // Se genera un nuevo token a partir del objeto usuario
            $token = JWTAuth::fromUser($usuario);

            return $this->generarJsonToken($token);
        } else {
            return response()->json(['error' => 'No se pudo crear el usuario'], 500);
        }
    }


    public function me()
    {
        //Se obtiene el token del request actual
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json(['error' => 'Token no registrado'], 401);
        }

        try {
            //Obtiene los datos reales del token ingresado
            $cargaReal = JWTAuth::getPayload($token);
        } catch (Exception $e) {
            return response()->json(['error' => 'Token sin información'], 500);
        }

        // Subject o id del usuario
        $usuarioId = $cargaReal['sub'];

        //Obtiene los datos desde la API a partir del ID del usuario
        $usuario = $this->userProvider->retrieveById($usuarioId);

        if ($usuario) {
            return response()->json($usuario);
        } else {
            return response()->json(['error' => 'Sin información'], 500);
        }
    }

    protected function generarJsonToken($token)
    {
        //Genera el json con la información del token
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth()->factory()->getTTL() * 60
        ]);
    }

    public function destroy()
    {
        $usuarioId  = auth()->user()->getAuthIdentifier();
        $url        = $this->userProvider->getApiUrl() .'/'. $usuarioId;
        $response   = Http::delete($url);
        if ($response->successful()) {
            //Invalida el token del usuario
            auth()->logout();
            return response()->json(['message' => 'Perfil eliminado correctamente']);
        } else {
            return response()->json(['error' => 'No se pudo eliminar el perfil'], $response->status());
        }

    }

    public function update(RegistrarUsuarioRequest $request)
    {
        $usuarioId = auth()->user()->getAuthIdentifier();
        $url = $this->userProvider->getApiUrl() .'/'. $usuarioId;
        $updateUsuario = [
            'nombre'    => $request->nombre,
            'email'     => $request->email,
        ];

        // Si la contraseña cambia, la encripta
        if ($request->has('password')) {
            $updateUsuario['password'] = bcrypt($request->password);
        }

        // Realiza la solicitud con la información recibida
        $response = Http::put($url, $updateUsuario);

        if ($response->successful()) {
            return response()->json(['message' => 'Perfil actualizado con éxito']);
        } else {
            return response()->json(['error' => 'No se pudo actualizar el perfil'], $response->status());
        }
    }
}
