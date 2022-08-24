<?php

use App\Http\Controllers\TodoItemController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/todos', [TodoItemController::class, 'index']);
Route::post('/todos', [TodoItemController::class, 'store']);
Route::delete('/todos/{id}', [TodoItemController::class, 'destroy']);

Route::put('/todos/{id}', [TodoItemController::class, 'changeStatus']);

//Route::apiResource('/todos', \App\Http\Controllers\TodoItemController::class);
