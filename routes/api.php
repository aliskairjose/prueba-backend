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


Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\RegisterController@register');

// Password Reset Routes
Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Api\ResetPasswordController@reset')->name('password.reset');

// Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');

    // User Routes
    Route::get('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show');
    Route::put('usrrs/{id}', 'UserController@update');

    // Product Routes
    Route::get('products', 'ProductController@index');
    Route::get('products/{id}', 'ProductController@show');
    Route::get('products/user/{id}', 'ProductController@myProducts');
    Route::post('products', 'ProductController@store');
    Route::put('products/{id}', 'ProductController@update');
    Route::delete('products/{id}', 'ProductController@delete');

    // ImportList Routes
    Route::get('importlist', 'ImportListController@index');
    Route::get('importlist/{id}', 'ImportListController@show');
    Route::post('importlist', 'ImportListController@store');
    Route::put('importlist/{id}', 'ImportListController@update');
    Route::delete('importlist/{id}', 'ImportListController@delete');

    // Variations Routes
    Route::get('variations', 'VariationController@index');
    Route::get('variations/{id}', 'VariationController@show');
    Route::post('variations', 'VariationController@store');
    Route::put('variations/{id}', 'VariationController@update');
    Route::delete('variations/{id}', 'VariationController@delete');

    // Attributes Routes
    Route::get('attributes', 'AttributesController@index');
    Route::get('attributes/{id}', 'AttributesController@show');
    Route::post('attributes', 'AttributesController@store');
    Route::put('attributes/{id}', 'AttributesController@update');
    Route::delete('attributes/{id}', 'AttributesController@delete');


// });
