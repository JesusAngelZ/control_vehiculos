<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Asegúrate de tener esta línea
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


         // Verificar si el usuario ya está autenticado
         if (auth()->check()) {
            return redirect()->route('principal'); // Cambia esto a la ruta que desees
        }

        return view('login.index');
    }

    //aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiii
    public function index_pricipal(){
        $isAuthenticated = auth()->check();
        //dd(auth()->check());
        $user = auth()->user();
        return view('principal.index', compact('isAuthenticated','user'));
    }

public function login(Request $request)
{
    // Validar la entrada
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    try {
        $credentials = $request->only('email', 'password');

        // Intentar generar el token
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        // Si todo va bien, devolver el token
        return $this->respondWithToken($token);

    } catch (JWTException $e) {
        // Manejar el error al crear el token
        return response()->json(['error' => 'No se pudo crear el token'], 500);
    } catch (\Exception $e) {
        // Manejar cualquier otro tipo de excepción
        return response()->json(['error' => 'Error desconocido: ' . $e->getMessage()], 500);
    }
}

        protected function respondWithToken($token)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        }


public function logout(Request $request)
{
    // Cierra la sesión del usuario
    auth()->logout();

    // Registrar las cookies actuales
    \Log::info('Cookies antes de eliminar:', $request->cookies->all());

    // Eliminar la cookie
    $response = response()->json(['message' => 'Successfully logged out'])
        ->cookie('jwt_token', '', -1, '/', null, true, true); // Expirar la cookie

    // Registrar las cookies después de eliminar
    \Log::info('Cookies después de eliminar:', $response->headers->getCookies());

    return $response;
}




}
