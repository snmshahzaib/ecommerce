<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminArea;
use App\Http\Middleware\CustomerArea;
use App\Http\Middleware\UserArea;
use App\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Product $product) {
    $data= [];
    $data['products'] = $product->paginate(3);
    return view('home.index', $data);
});
// Route::get('/', 'LoadMoreController@index');
Route::get('/product_detail/{id}', 'LoadMoreController@detail')->name('product.detail');
Route::post('/comments', 'CommentController@store')->name('comments.store');
// Route::post('/load_data', 'LoadMoreController@load_data')->name('loadmore.load_data');



Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@home')->name('home')->middleware('auth', 'verified');
Route::prefix('admin')->middleware('admin_area')->group(function(){
    Route::get('/dashboard', 'HomeController@admin');
    Route::get('/category', 'CategoryController@index');
    Route::post('/add_category', 'CategoryController@store');
    Route::delete('/delete_category/{id}', 'CategoryController@destroy')->name('delete.category');
    Route::post('/update_category/{id}', 'CategoryController@update')->name('category.update');

    Route::get('/addproduct', 'ProductController@index');
    Route::post('/store_product', 'ProductController@store');
    Route::get('/showproduct', 'ProductController@show');
    Route::delete('/delete_producty/{id}', 'ProductController@destroy')->name('delete.product');
    Route::post('/update_product/{id}', 'ProductController@update')->name('product.update');

    Route::get('/orders', 'OrdersController@index');
    Route::post('change_status', 'OrdersController@update');
    Route::get('generate-pdf/{id}','OrdersController@generatePDF');

    Route::get('/live_search/action', 'OrdersController@action')->name('live_search.action');

    Route::get('send', 'HomeController@sendNotification');
});
Route::prefix('customer')->middleware('customer_area')->group(function(){
    Route::get('/home', 'HomeController@customer');
    Route::get('/product_detail/{id}', 'LoadMoreController@detail')->name('product.detail');
    Route::post('/home/{id}', 'CartController@store')->name('add.to.cart');
    Route::get('/cart', 'CartController@index')->name('cart');

    Route::get('/orders', 'OrderController@show');
    Route::post('/cancel_order/{id}', 'OrderController@update')->name('cancel.order');

    Route::patch('update-cart', 'CartController@update')->name('update.cart');
    Route::delete('remove-from-cart', 'CartController@remove')->name('remove.from.cart');

    Route::get('/payment_method', 'OrderController@index')->name('checkout');
    Route::post('/ordered', 'OrderController@store');

    Route::post('stripe', 'OrderController@stripePay')->name('stripe.post');

    Route::post('charge', 'OrderController@charge');
    Route::get('success', 'OrderController@success');
    Route::get('error', 'OrderController@error');

});
