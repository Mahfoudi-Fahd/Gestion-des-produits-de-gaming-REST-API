<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
// Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');


Route::post('/forgot',[AuthController::class,'forgot']);
Route::post('/reset',[AuthController::class,'reset']);



Route::group(['controller' => ResetPasswordController::class], function (){
    // Request password reset link
    Route::post('forgot-password', 'sendResetLinkEmail')->middleware('guest')->name('password.email');
    // Reset password
    Route::post('reset-password', 'resetPassword')->middleware('guest')->name('password.update');

    Route::get('reset-password/{token}', function (string $token) {
         return $token;
     })->middleware('guest')->name('password.reset');
});


// update profile 

Route::put('user/{user}', [ProfileController::class, 'updateProfile']);



// Category Route 

// Route::apiResource('categories', CategoryController::class);


Route::group(['controller' => CategoryController::class, 'prefix' => '/categories','middleware'=>'auth:sanctum'], function () {
    Route::get('', 'index')->middleware(['permission:view category']);
    Route::post('', 'store')->middleware(['permission:add category']);
    Route::get('/{category}', 'show')->middleware(['permission:view category']);
    Route::put('/{category}', 'update')->middleware(['permission:edit category']);
    Route::delete('/{category}', 'destroy')->middleware(['permission:delete category']);
    Route::get('getProductsByCategoryName/{category}', 'getProductsByCategoryName');
});



// Products Route
Route::group(['controller' => ProductController::class, 'prefix' => '/products','middleware'=>'auth:sanctum'], function () {
    Route::post('', 'store')->middleware(['permission:add product']);
    Route::put('/{product}', 'update')->middleware(['permission:edit All products|edit My product']);
    Route::delete('/{product}', 'destroy')->middleware(['permission:delete All products|delete My product']);
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/products/{product}', 'show');
});


Route::group(['controller' => RoleController::class, 'prefix' => 'roles','middleware'=>'auth:sanctum'], function () {
    Route::get('', 'index')->middleware(['permission:view role']);
    Route::post('', 'store')->middleware(['permission:add role']);
    Route::get('/{role}', 'show')->middleware(['permission:view role']);
    Route::put('/{role}', 'update')->middleware(['permission:edit role']);
});




Route::group(['controller' => PermissionController::class , 'middleware'=>'auth:sanctum'],function(){
    Route::post('give-permission/{role}', 'givePermissionToRole')->middleware('permission:give permission');
Route::delete('remove-permission/{role}','removePermissionFromRole')->middleware('permission:remove permission');
});


// Roles
Route::group(['controller' => RoleController::class , 'middleware'=>'auth:sanctum'], function()
{
    Route::post('give-role/{id}', 'assignRole')->middleware('permission:give role');
    Route::post('remove-role/{id}', 'removeRole')->middleware('permission:remove role');
});