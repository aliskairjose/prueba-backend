<?php

namespace App\Http\Controllers;

use App\Http\Resources\LandingPage as LandingPageResource;
use App\Http\Resources\LandingPageCollection;
use App\LandingPage;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LandingPageController extends Controller
{

    /**
     * Devuelve el landing del usuario logueado
     * @param $id
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $user = $this->getAuthenticatedUser();
            $data = new LandingPageCollection(LandingPage::where('user_id', $user->id)->get());
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

    public function getByUrl(Request $request)
    {
        try {
            $data = new LandingPageCollection(LandingPage::where('url', $request->url)->get());
        }
        catch ( ModelNotFoundException $e){
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'No se encontro registro',
                'error'     => $e
              ]
            );
        }
        catch (Exception $e){
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
            $data = LandingPage::create(
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
            LandingPage::findOrFail($id)->update($request->all());
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
            'message'   => 'El LandingPage page ha sido actualizado'
          ]
        );
    }

    public function delete($id)
    {
        try {
            LandingPage::findOrFaail($id)->delete();
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
            'message'   => 'El LandingPage page ha sido eliminado'
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
