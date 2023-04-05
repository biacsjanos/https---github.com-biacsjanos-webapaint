<?php


use App\Http\Controllers\Api\DrawController;
use App\Http\Controllers\Api\ShapeController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('draws', DrawController::class);
    Route::resource('shapes', ShapeController::class);
    Route::get('shape/{id}', 'App\Http\Controllers\Api\ShapeController@show');
    Route::put('shape/{shape}/{attrib}/{color}', 'App\Http\Controllers\Api\ShapeController@create');
    Route::put('draw-create/{name}/{shapeid}/{x}/{y}', 'App\Http\Controllers\Api\ShapeController@store');

});

