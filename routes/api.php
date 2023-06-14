<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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

/**** 
| Instead of naming all individual routes, you can use a resource for basic CRUD functionality. 
|
| Router::resource('/products', ProductController::class)
|
*/

/**
 *  Public Routes
 * 
 */

// Products
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{query}', [ProductController::class, 'search']);

// Authentication
Route::post('/register', [AuthController::class, 'register']);

/**
 *  Private Routes
 * 
 */


// Products
Route::post('/products', [ProductController::class, 'store'])->middleware('auth:sanctum');
Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('auth:sanctum');

// Authentication
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
