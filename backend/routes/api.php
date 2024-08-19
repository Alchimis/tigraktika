<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ComponentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, "getAllProducts"]);
Route::post('/product', [ProductController::class, "createProduct"]);
Route::post('/products', [ProductController::class, "createProducts"]);
Route::delete('/product', [ProductController::class, "deleteProduct"]);
Route::post('/product/addComponent', [ProductController::class, "addComponentToProduct"]);
Route::post('/product/move', [ProductController::class, "move"]);
Route::post('/component', [ComponentController::class, "createComponent"]);
