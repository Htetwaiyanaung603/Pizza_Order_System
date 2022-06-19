<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', 'AuthController@register'); //register
Route::post('login', 'AuthController@login'); //login

Route::get('apitest', function () {
   $category = Category::get();
   $response = [
       'status' => 200,
       'message' => 'success',
       'data' => $category,
   ];
   return Response::json($response);
});


Route::group(['prefix' => 'category', 'namespace' => 'API', 'middleware' => 'auth:sanctum'], function() {
    Route::get('list', 'ApiController@categoryList'); //list
    Route::post('create', 'ApiController@categoryCreate'); //create
    Route::get('details/{id}', 'ApiController@categoryDetails'); //details
    Route::get('delete/{id}', 'ApiController@categoryDelete'); //delete
    Route::post('update', 'ApiController@categoryUpdate'); //update
});

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('logout', 'AuthController@logout'); //logout
});