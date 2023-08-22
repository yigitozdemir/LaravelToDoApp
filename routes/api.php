<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterContoller;
use App\Http\Controllers\ProjectController;

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
