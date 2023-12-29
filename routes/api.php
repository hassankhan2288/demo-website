<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Front\TransactionController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     //return $request->user();
//     return 1;
// });

// Route::get('/products','Api\ApiController@products')->name('products');
// Route::get('/banners','Api\ApiController@banners')->name('banners');
// Route::get('/brands','Api\ApiController@brands')->name('brands');
// Route::get('/categories','Api\ApiController@categories')->name('categories');
// Route::get('/product/sales','Api\ApiController@productSales')->name('productSales');

/** mobile api **/
Route::post('login', [LoginController::class, 'login']);
Route::post('signup', [LoginController::class, 'signup']);


Route::macro('category', function ($uri, $controller) {
    Route::apiResource($uri, $controller);
});
Route::category('categories', CategoryController::class);

Route::macro('banner', function ($uri, $controller) {
    Route::apiResource($uri, $controller);
});
Route::banner('banners', BannerController::class);

Route::macro('warehouse', function ($uri, $controller) {
    Route::apiResource($uri, $controller);
});
Route::warehouse('warehouses', WareHouseController::class);




Route::group(['middleware' => 'auth:sanctum'], function () {
    
    Route::macro('order', function ($uri, $controller) {
        Route::get("{$uri}/slots", "{$controller}@getAvailableSlots");
        Route::apiResource($uri, $controller);
    });
    Route::order('order', OrderController::class);

    /********** Product ***********/

    Route::macro('product', function ($uri, $controller) {
        //Route::post("{$uri}/upload", "{$controller}@upload");
        Route::get("{$uri}/product-promotions", "{$controller}@productPromotions");
        Route::apiResource($uri, $controller);
    });
    Route::product('product', ProductController::class);

});
// Route::post('/process-payment', [TransactionController::class, 'processPayment'])->name('processPayment');
Route::get('/product-prices','Api\ApiController@productPriceUpdate');

//CRONE
// Route::get('/update-prices-product','Api\ApiController@productPriceUpdate');
// Route::get('/update-location-wise-stock','Api\ApiController@LocationWiseStock');