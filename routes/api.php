<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterContoller;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TodoItemController;

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
Route::controller(RegisterContoller::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');

});

Route::controller(ProjectController::class)->group(function(){
    Route::post('list', 'list');
    Route::post('add', 'add');
    Route::delete('delete/{id}', 'delete');
})->middleware('auth:sanctum');


Route::controller(TodoItemController::class)->prefix('item')->group(function(){
    Route::post('list/{project_id}', 'list');
    Route::post('add/{project_id}', 'add');
    Route::post('update/{item}/{status}', 'change_status');
    Route::post('delete/{item}', 'delete');
})->middleware('auth:sanctum');
