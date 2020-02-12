<?php

namespace App\Http\Controllers;

use App\Http\Resources\LandingPage as LandingPageResource;
use App\Http\Resources\LandingPageCollection;
use App\LandingPage;
use App\Mail\LandingPageMail;
use App\Product;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
            $user = LandingPage::getAuthenticatedUser();
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
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status'    => 400,
                    'message'   => 'No se encontro registro',
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

    public function mail(Request $request)
    {

        try {

            $user = User::findOrFail($request->user_id);
            $product = Product::findOrFail($request->product_id);

            $data = array(
                "user_id"       => $request->user_id,
                "user_full_name"=> $user->name . " " . $user->surname,
                "product_id"    => $request->product_id,
                "product_name"  => $product->name,
                "first_name"    => $request->first_name,
                "last_name"     => $request->last_name,
                "email"         => $request->email,
                "phone"         => $request->phone,
                "address"       => $request->address,
                "city"          => $request->city,
                "country"       => $request->country,
                "zip_code"      => $request->zip_code,
                "note"          => $request->note
            );


            // Usando queue en lugar de send, el correo se envia en segundo plano!
            Mail::to($user->email)->queue(new LandingPageMail($data));
        } catch (Exception $e) {
            return response()->json(
                [
                    'isSuccess' => true,
                    'status'    => 400,
                    'message'   => 'Ha ocurrido un error',
                ]
            );
        }

        return response()->json(
            [
                'isSuccess' => true,
                'status'    => 200,
                'message'   => 'Mensaje enviado con exito'
            ]
        );
    }
}
