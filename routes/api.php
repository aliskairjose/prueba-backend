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
Route::post('sendMail', 'UserController@sendMail');

// Password Reset Routes
Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Api\ResetPasswordController@reset')->name('password.reset');

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('logout', 'ApiController@logout');

    // User Routes
    Route::get('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show');
    Route::put('users/{id}', 'UserController@update');
    Route::post('users', 'UserController@store');
    Route::post('users/changepassword', 'UserController@changePassword');
    Route::post('users/banuser', 'UserController@banUser');
    Route::put('users/updaterole/{id}', 'UserController@updaterole');

    // Product Routes
    Route::get('products', 'ProductController@index');
    Route::get('products/{id}', 'ProductController@show');
    Route::get('products/user/{id}', 'ProductController@myProducts');
    Route::post('products', 'ProductController@store');
    Route::post('products/import', 'ProductController@import');
    Route::put('products/{id}', 'ProductController@update');
    Route::delete('products/{id}', 'ProductController@delete');

    // ImportList Routes
    Route::get('importlist', 'ImportListController@index');
    Route::post('importlist', 'ImportListController@store');
    Route::put('importlist/{id}', 'ImportListController@update');
    Route::delete('importlist/{id}', 'ImportListController@delete');
    Route::put('importlist/importstore/{id}', 'ImportListController@updateImportedToStore');
    Route::put('importlist/product/update/{id}', 'ImportListController@updateProductName');

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
    Route::get('attributes/values', 'AttributeValueController@index');
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
    Route::get('separateinventories/products/{id}', 'SeparateInventoryController@dropshipperProducts');
    Route::post('separateinventories', 'SeparateInventoryController@store');
    Route::put('separateinventories/{id}', 'SeparateInventoryController@update');
    Route::delete('separateinventories/{id}', 'SeparateInventoryController@delete');

    // HistoryInventories Routes
    Route::get('inventories/history', 'HistoryInventoriesController@index');
    Route::get('inventories/history/{id}', 'HistoryInventoriesController@show');
    Route::get('inventories/history/{id}', 'HistoryInventoriesController@getByHistoryInventoriesId');
    Route::post('inventories/history', 'HistoryInventoriesController@store');
    Route::put('inventories/history/{id}', 'HistoryInventoriesController@update');
    Route::delete('inventories/history/{id}', 'HistoryInventoriesController@delete');


    // ProductPhoto Routes
    Route::get('product/photos', 'ProductPhotosController@index');
    Route::post('product/photos/upload', 'ProductPhotosController@store');
    Route::put('product/photos/{id}', 'ProductPhotosController@update');
    Route::delete('product/photos/{id}', 'ProductPhotosController@delete');

    // My Orders Routes
    Route::get('orders/myorders', 'MyOrderController@index');
    Route::get('orders/myorders/supplier/{id}', 'MyOrderController@supplier');
    Route::get('orders/myorders/dropshipper/{id}', 'MyOrderController@dropshipper');
    Route::post('orders/myorders', 'MyOrderController@store');
    Route::post('orders/myorders/import', 'MyOrderController@import');
    Route::put('orders/myorders/{id}', 'MyOrderController@update');
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

    //Role Routes
    Route::get('roles', 'RoleController@index');
    Route::get('roles/{id}', 'RoleController@show');
    Route::post('roles', 'RoleController@store');
    Route::delete('roles/{id}', 'RoleController@delete');
    Route::put('roles/{id}', 'RoleController@update');

    //Payu routes
    Route::get('payu/payment_methods', 'PayuController@getPaymentMethods');
    Route::get('payu/pse_banks', 'PayuController@getPseBanks');
    Route::post('payu/send_payment', 'PayuController@sendPayment');
    Route::post('payu/notifyurl', 'PayuController@notifyurl');
    Route::get('payu/getresponseprueba', 'PayuController@getresponseprueba');



    // LandingPage Page Routes
    Route::get('landing', 'LandingPageController@index');
    Route::post('landing', 'LandingPageController@store');
    Route::post('landing/url', 'LandingPageController@getByUrl');
    Route::put('landing/{id}', 'LandingPageController@update');
    Route::delete('landing/{id}', 'LandingPageController@delete');

    // Wallet Route
    Route::get('wallet', 'WalletController@index');
    Route::get('wallet/{id}', 'WalletController@show');
    Route::post('wallet', 'WalletController@store');
    Route::put('wallet/{id}', 'WalletController@update');
    Route::put('wallet/add/{id}', 'WalletController@addBalance');

    // WithdrawalRequest Routes
    Route::get('withdrawal', 'WithdrawalRequestController@index');
    Route::get('withdrawal/{id}', 'WithdrawalRequestController@show');
    Route::post('withdrawal', 'WithdrawalRequestController@store');
    Route::put('withdrawal/{id}', 'WithdrawalRequestController@update');

    // Currency Routes
    Route::get('currency', 'CurrencyController@index');
    Route::get('currency/{id}', 'CurrencyController@show');
    Route::post('currency', 'CurrencyController@store');
    Route::delete('currency/{id}', 'CurrencyController@delete');
    Route::put('currency/{id}', 'CurrencyController@update');

    // Department Routes
    Route::get('department', 'DepartmentController@index');
    Route::get('department/{id}', 'DepartmentController@show');
    Route::post('department', 'DepartmentController@store');
    Route::delete('department/{id}', 'DepartmentController@delete');
    Route::put('department/{id}', 'DepartmentController@update');

    // City Routes
    Route::get('city', 'CityController@index');
    Route::get('city/{id}', 'CityController@show');
    Route::post('city', 'CityController@store');
    Route::delete('city/{id}', 'CityController@delete');
    Route::put('city/{id}', 'CityController@update');

    // Trajectory Routes
    Route::get('trajectory', 'TrajectoryController@index');
    Route::post('loadsinrecaudo', 'TrajectoryController@loadsinrecaudo');
    Route::post('loadconrecaudo', 'TrajectoryController@loadconrecaudo');
});
