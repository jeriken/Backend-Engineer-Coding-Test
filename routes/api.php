<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TodoController;
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

Route::get('activity-groups', [ActivityController::class, 'index']);
Route::post('activity-groups', [ActivityController::class, 'store']);
Route::get('activity-groups/{id}', [ActivityController::class, 'show']);
Route::patch('activity-groups/{id}', [ActivityController::class, 'update']);
Route::delete('activity-groups/{id}', [ActivityController::class, 'destroy']);

Route::get('todo-items', [TodoController::class, 'index']);
Route::post('todo-items', [TodoController::class, 'store']);
Route::get('todo-items/{id}', [TodoController::class, 'show']);
Route::patch('todo-items/{id}', [TodoController::class, 'update']);
Route::delete('todo-items/{id}', [TodoController::class, 'destroy']);