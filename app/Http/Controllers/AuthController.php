<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','loginpost']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */


//VISTA
     public function login(Request $request)
     {
         $credentials = $request->only('email', 'password');

         if (! $token = auth()->attempt($credentials)) {
             return redirect()->back()->withErrors(['email' => 'Credenciales incorrectas.']);
         }

         return redirect()->route('principal123')->with('message', '¡Bienvenido de nuevo!');
     }



     public function loginpost()
     {
         $credentials = request(['email', 'password']);

         if (! $token = auth()->attempt($credentials)) {
             return response()->json(['error' => 'Unauthorized'], 401);
         }

         return $this->respondWithToken($token);
     }



/*
   public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
/*

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

     //Esta función es la encargada de cerrar la sesión


   /*
     public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
*/


//Vista

public function logout()
{
    auth()->logout();

    // Eliminar la cookie
    return response()->json(['message' => 'Successfully logged out'])
        ->cookie('jwt_token', '', -1); // Expirar la cookie
}


    //VISTA
    public function refresh()
    {
        $token = auth()->refresh(); // Generar un nuevo token

        // Devolver el token renovado en una cookie
        return response()->json(['message' => 'Token renovado'])
            ->cookie('jwt_token', $token, 60, null, null, false, true);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        // Validar la entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Si la validación falla, devolver errores de validación
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Error de validación: ' . implode(', ', $validator->errors()->all())
            ], 422); // Código de estado para errores de validación
        }

        try {
            // Crear el usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Iniciar sesión automáticamente después del registro
            Auth::login($user);

            // Redirigir al usuario a la ruta deseada
            return response()->json([
                'message' => 'Registro exitoso',
                'refresh' => true,
            ]);

        } catch (\Exception $e) {
            // Manejar cualquier excepción que ocurra
            return response()->json(['error' => 'Error desconocido: ' . $e->getMessage()], 500);
        }
    }
}
