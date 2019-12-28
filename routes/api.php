<?php

use Illuminate\Http\Request;

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

Route::post( 'login', 'Auth\LoginController@login');
Route::post( 'register', 'Auth\LoginController@register');
Route::post( 'forgot_password', 'Auth\ForgotPasswordController@forgot_password');

Route::group( [ 'middleware' => 'auth.jwt' ], function () {
    Route::get( 'logout', 'ApiController@logout' );

} );
