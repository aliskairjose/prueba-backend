<?php

use Illuminate\Http\Request;
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

//Route::group(['middleware' => 'auth.jwt'], function () {
Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('logout', 'ApiController@logout');

// User Routes
    Route::get('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show');
    Route::put('users/{id}', 'UserController@update');
    Route::post('users/changepassword', 'UserController@changePassword');
    Route::post('users/supplier', 'UserController@createSupplier');
    Route::post('users/banuser', 'UserController@banUser');


// Product Routes
    Route::get('products', 'ProductController@index');
    Route::get('products/{id}', 'ProductController@show');
    Route::get('products/user/{id}', 'ProductController@myProducts');
    Route::post('products', 'ProductController@store');
    Route::put('products/{id}', 'ProductController@update');
    Route::delete('products/{id}', 'ProductController@delete');

// ImportList Routes
    Route::get('importlist', 'ImportListController@index');
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
    Route::get('attributes', 'AttributeController@index');
    Route::get('attributes/{id}', 'AttributeController@show');
    Route::post('attributes', 'AttributeController@store');
    Route::put('attributes/{id}', 'AttributeController@update');
    Route::delete('attributes/{id}', 'AttributeController@delete');

// Attributes Values Routes
// Route::get('attributes/values', 'AttributeValueController@index');
    Route::get('attributes/values/{id}', 'AttributeValueController@show');
    Route::post('attributes/values', 'AttributeValueController@store');
// Route::put('attributes/values/{id}', 'AttributeValueController@update');
    Route::delete('attributes/values/{id}', 'AttributeValueController@delete');

// Attributes Variations Routes
// Route::get('attributes/variations', 'AttributesVariationsController@index');
    Route::get('attributes/variations/{id}', 'AttributesVariationsController@show');
    Route::post('attributes/variations', 'AttributesVariationsController@store');
// Route::put('attributes/variations/{id}', 'AttributesVariationsController@update');
    Route::delete('attributes/variations/{id}', 'AttributesVariationsController@delete');

// SeparateInventory Routes
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

// RequestTestDetail Routes
    Route::get('requesttest/detail', 'RequestTestDeailController@index');
    Route::get('requesttest/detail/{id}', 'RequestTestDeailController@show');
    Route::post('requesttest/detail', 'RequestTestDeailController@store');
    Route::put('requesttest/detail/{id}', 'RequestTestDeailController@update');
    Route::delete('requesttest/detail/{id}', 'RequestTestDeailController@delete');

// ProductPhoto Routes
    Route::get('product/photos', 'ProductPhotosController@index');
    Route::post('product/photos/upload', 'ProductPhotosController@store');
    Route::put('product/photos/{id}', 'ProductPhotosController@update');
    Route::delete('product/photos/{id}', 'ProductPhotosController@delete');

// RequestTest Routes
    Route::get('requesttest/user/{id}', 'RequestTestController@myRequestTest');

     Route::get('requesttest', 'RequestTestController@index');
     Route::get('requesttest/{id}', 'RequestTestController@show');
     Route::post('requesttest', 'RequestTestController@store');
     Route::put('requesttest/{id}', 'RequestTestController@update');
     Route::delete('requesttest/{id}', 'RequestTestController@delete');


// My Orders Routes
    Route::post('orders/myorders', 'MyOrderController@store');
    Route::get('orders/myorders/{id}', 'MyOrderController@show');

// Order History Routes
    Route::get('orders/history', 'RecordController@index');
    Route::get('orders/history/{id}', 'RecordController@show');
    Route::post('orders/history', 'RecordController@store');
    Route::delete('orders/history/{id}', 'RecordController@delete');

// Category Routes
    Route::get('categories', 'CategoryController@index');
    Route::get('categories/{id}', 'CategoryController@show');
    Route::post('categories', 'CategoryController@store');
    Route::delete('categories/{id}', 'CategoryController@delete');
    Route::put('categories/{id}', 'CategoryController@update');

// Payment Method Routes
    Route::get('paymentmethods', 'PaymentMethodController@index');
    Route::get('paymentmethods/{id}', 'PaymentMethodController@show');
    Route::post('paymentmethods', 'PaymentMethodController@store');
    Route::delete('paymentmethods/{id}', 'PaymentMethodController@delete');
    Route::put('paymentmethods/{id}', 'PaymentMethodController@update');

});
