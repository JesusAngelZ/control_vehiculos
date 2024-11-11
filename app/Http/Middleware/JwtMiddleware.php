<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Log;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

/*



    //SOLO PARA PRUEBAS DE TOKENS
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }*/


    //  Cada Token tiene duración de 60 minutos
    //Token con vista
    public function handle($request, Closure $next)
    {
        // Verificar si el token JWT existe en las cookies
        if ($request->hasCookie('jwt_token')) {
            // Añadir el token JWT de la cookie a la cabecera Authorization
            $request->headers->set('Authorization', 'Bearer ' . $request->cookie('jwt_token'));
        } else {
            //return response()->json(['status' => 'Authorization Token not found'], 401);
            return redirect('/');
        }

        try {
            // Autenticación del usuario
            $user = JWTAuth::parseToken()->authenticate();

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return redirect('/');
                //return response()->json(['status' => 'Token is Invalid'], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return redirect('/');
              //  return response()->json(['status' => 'Token is Expired'], 401);
            } else {
                return redirect('/');
                //  return response()->json(['status' => 'Authorization Token not found'], 401);
            }
        }
       // return $next($request);
       return $next($request);
    }
}
