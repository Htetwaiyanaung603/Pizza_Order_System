<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserCheckMiddleware;
use App\Http\Middleware\AdminCheckMiddleware;

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

Route::get('/', function () {
    // return view('auth.login');
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
       // return view('dashboard');

       //check login admin or user
       if(Auth::check()){

           if(Auth::user()->role == 'admin'){
               return redirect()->route('admin#profile');
           }else if(Auth::user()->role == 'user'){
               return redirect()->route('user#index');
           }
       }
    })->name('dashboard');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => [AdminCheckMiddleware::class]], function () {
    Route::get('profile', 'AdminController@profile')->name('admin#profile');
    Route::post('profile/{id}', 'AdminController@updateProfile')->name('admin#updateProfile');
    Route::get('changePassword', 'AdminController@changePassword')->name('admin#changePassword');
    Route::post('changePassword/{id}', 'AdminController@change')->name('admin#change');

    Route::get('category', 'CategoryController@category')->name('admin#category');
    Route::get('addCategory', 'CategoryController@addCategory')->name('admin#addCategory');
    Route::post('createCategory', 'CategoryController@createCategory')->name('admin#createCategory');
    Route::get('deleteCategory/{id}', 'CategoryController@deleteCategory')->name('admin#deleteCategory');
    Route::get('editCategory/{id}', 'CategoryController@editCategory')->name('admin#editCategory');
    Route::post('updateCategory', 'CategoryController@updateCategory')->name('admin#updateCategory');
    Route::get('category/search', 'CategoryController@searchCategory')->name('admin#searchCategory');
    Route::get('categoryItem/{id}', 'CategoryController@categoryItem')->name('admin#categoryItem');
    Route::get('category/download', 'CategoryController@categoryDownload')->name('admin#categoryDownload');

    Route::get('pizza', 'PizzaController@pizza')->name('admin#pizza');
    Route::get('addPizza', 'PizzaController@addPizza')->name('admin#addPizza');
    Route::post('addPizza', 'PizzaController@createPizza')->name('admin#createPizza');
    Route::get('deletePizza/{id}', 'PizzaController@deletePizza')->name('admin#deletePizza');
    Route::get('infoPizza/{id}' , 'PizzaController@infoPizza')->name('admin#infoPizza');
    Route::get('editPizza/{id}', 'PizzaController@editPizza')->name('admin#editPizza');
    Route::post('updatePizza/{id}', 'PizzaController@updatePizza')->name('admin#updatePizza');
    Route::get('pizza/search', 'PizzaController@searchPizza')->name('admin#searchPizza');
    Route::get('pizza/download', 'PizzaController@pizzaDownload')->name('admin#pizzaDownload');

    Route::get('userList', 'UserController@userList')->name('admin#userList');
    Route::get('adminList', 'UserController@adminList')->name('admin#adminList');
    Route::get('userSearch', 'UserController@userSearch')->name('admin#userSearch');
    Route::get('userDelete/{id}', 'UserController@userDelete')->name('admin#userDelete');
    Route::get('adminSearch', 'UserController@adminSearch')->name('admin#adminSearch');
    Route::get('adminDelete/{id}', 'UserController@userDelete')->name('admin#adminDelete');
    Route::get('user/download', 'UserController@userDownload')->name('admin#userDownload');
    Route::get('admin/download', 'UserController@adminDownload')->name('admin#adminDownload');



    Route::get('contact/list', 'ContactController@contactList')->name('admin#contactList');
    Route::get('contact/search', 'ContactController@contactSearch')->name('admin#contactSearch');
    Route::get('contact/download', 'ContactController@contactDownload')->name('admin#contactDownload');

    Route::get('order/list', 'OrderController@orderList')->name('admin#orderList');
    Route::get('order/search', 'OrderController@orderSearch')->name('admin#orderSearch');
    Route::get('order/download', 'OrderController@orderDownload')->name('admin#orderDownload');

});


Route::group(['prefix' => 'user', 'middleware' => [UserCheckMiddleware::class]], function() {
    Route::get('/', 'UserController@index')->name('user#index');
    Route::post('contact/create', 'Admin\ContactController@createContact')->name('admin#createContact');
    Route::get('category/{id}', 'UserController@category')->name('user#category');
    Route::get('details/{id}', 'UserController@details')->name('admin#details');
    Route::get('search/item', 'UserController@searchItem')->name('admin#searchItem');
    Route::get('search/price', 'UserController@searchPrice')->name('admin#searchPrice');
    Route::get('order', 'UserController@orderPizza')->name('user#orderPizza');
    Route::post('order', 'UserController@placeOrder')->name('user#placeOrder');
});