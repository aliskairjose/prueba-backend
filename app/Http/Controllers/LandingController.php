<?php

namespace App\Http\Controllers;

use App\Http\Resources\Landing as LandingResource;
use App\Landing;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LandingController extends Controller
{

    /**
     * Devuelve el landing del usuario logueado
     * @param $id
     * @return JsonResponse
     */
    public function show()
    {
        try {
            $user = $this->getAuthenticatedUser();
            $data = new LandingResource(Landing::where('user_id', $user->id));
        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'No se encontro landing que mostrar',
                'error'     => $e
              ]
            );
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'Ha ocurrido un error',
                'error'     => $e
              ]
            );
        }
        return response()->json(
          [
            'isSuccess' => true,
            'status'    => 200,
            'objects'   => $data
          ]
        );
    }

    public function store(Request $request)
    {
        try {
            $user = $this->getAuthenticatedUser();
            $data = Landing::create(
              [
                'user_id'    => $user->id,
                'product_id' => $request->product_id,
                'url'        => $request->url,
              ]
            );
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'Ha ocurrido un error',
                'error'     => $e
              ]
            );
        }
        return response()->json(
          [
            'isSuccess' => true,
            'status'    => 200,
            'objects'   => $data
          ]
        );
    }

    public function update(Request $request, $id)
    {
        try {
            Landing::findOrFail($id)->update($request->all());
        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'No se encontro landing que mostrar',
                'error'     => $e
              ]
            );
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'Ha ocurrido un error',
                'error'     => $e
              ]
            );
        }
        return response()->json(
          [
            'isSuccess' => true,
            'status'    => 200,
            'message'   => 'El Landing page ha sido actualizado'
          ]
        );
    }

    public function delete($id)
    {
        try {
            Landing::findOrFaail($id)->delete();
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'Ha ocurrido un error',
                'error'     => $e
              ]
            );
        }
        return response()->json(
          [
            'isSuccess' => true,
            'status'    => 200,
            'message'   => 'El Landing page ha sido eliminado'
          ]
        );
    }

    private function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired']);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid']);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent']);
        }
        return $user;
    }

}
