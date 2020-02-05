<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth as JWTAuthJWTAuth;
use  JWTAuth;

class  AuthController extends Controller
{

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        $token = null;

        var_dump($credentials);
        var_dump($token);
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'isSuccess' => false,
                    'status'    => 401,
                    'message'   => 'La combinación de inicio de sesión / correo electrónico no es correcta, intente nuevamente.',
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'isSuccess' => false,
                'status' => 500,
                'message' => 'No se pudo crear el token'
            ]);
        }

        $user = new UserResource((User::where('email', $request->get('email')))->firstOrFail());

        return response()->json([
            'isSuccess' => true,
            'message'   => 'Ha ingresado al sistema correctamente',
            'status'    => 200,
            'token'     => $token,
            'objects'   => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                'isSuccess' => true,
                'status'  => 200,
                'message' => 'Cierre de sesión exitoso.'
            ]);
        } catch (JWTException  $exception) {
            return response()->json([
                'isSuccess' => false,
                'status'  => '500',
                'message' => 'Ha ocurrido un error inesperado.'
            ], 500);
        }
    }

    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);
        return response()->json(['user' => $user]);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

}
