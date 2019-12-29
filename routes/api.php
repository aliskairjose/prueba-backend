<?php

use App\Mail\RecoveryPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('recovery/password', function (Request $request) {

    $email = $request->get('email');

    try {
        Mail::to($email)->send(new RecoveryPassword);
    } catch (\Exception $e) {
        return response()->json([
            'isSuccess' => false,
            'message' => 'No se pudo enviar el correo a '.$email,
            'error'=> $e
        ]);
    }

    return response()->json([
        'isSuccess' => true,
        'messagge' => 'El mensaje ha sido enviado con exito a '. $email
    ]);
});

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
});
