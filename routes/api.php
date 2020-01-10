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
    Route::put('users/{id}', 'UserController@update');

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

    // SeparateInventorySeeder Routes
    Route::get('separateinventories', 'SeparateInventoryController@index');
    Route::get('separateinventories/{id}', 'SeparateInventoryController@show');
    Route::post('separateinventories', 'SeparateInventoryController@store');
    Route::put('separateinventories/{id}', 'SeparateInventoryController@update');
    Route::delete('separateinventories/{id}', 'SeparateInventoryController@delete');

    // SeparateInventoryDetail Routes
    Route::get('separateinventories/detail', 'SeparateDetailController@index');
    Route::get('separateinventories/detail/{id}', 'SeparateDetailController@show');
    Route::get('separateinventories/detail/{id}', 'SeparateDetailController@getBySeparateInventoryId');
    Route::post('separateinventories/detail', 'SeparateDetailController@store');
    Route::put('separateinventories/detail/{id}', 'SeparateDetailController@update');
    Route::delete('separateinventories/detail/{id}', 'SeparateDetailController@delete');

    // RequestTest Routes
    Route::get('requesttest', 'RequestTestController@index');
    Route::get('requesttest/{id}', 'RequestTestController@show');
    Route::post('requesttest', 'RequestTestController@store');
    Route::put('requesttest/{id}', 'RequestTestController@update');
    Route::delete('requesttest/{id}', 'RequestTestController@delete');

    // RequestTestDetail Routes
    Route::get('requesttest/detail', 'RequestTestDeailController@index');
    Route::get('requesttest/detail/{id}', 'RequestTestDeailController@show');
    Route::post('requesttest/detail', 'RequestTestDeailController@store');
    Route::put('requesttest/detail/{id}', 'RequestTestDeailController@update');
    Route::delete('requesttest/detail/{id}', 'RequestTestDeailController@delete');


// });
