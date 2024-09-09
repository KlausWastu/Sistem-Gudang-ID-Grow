<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MutationController;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

Route::group(['middleware' => 'api', 'prefix' => 'category'], function () {
    Route::get('/', [CategoryController::class, 'list'])->middleware('auth:api')->name('list');
    Route::get('/{id}', [CategoryController::class, 'filterList'])->middleware('auth:api')->name('filterList');
    Route::post('/', [CategoryController::class, 'create'])->middleware('auth:api')->name('create');
    Route::put('/{id}', [CategoryController::class, 'update'])->middleware('auth:api')->name('update');
    Route::delete('/{id}', [CategoryController::class, 'delete'])->middleware('auth:api')->name('delete');
});

Route::group(['middleware' => 'api', 'prefix' => 'location'], function () {
    Route::get('/', [LocationController::class, 'list'])->middleware('auth:api')->name('list');
    Route::get('/{id}', [LocationController::class, 'filterList'])->middleware('auth:api')->name('filterList');
    Route::post('/', [LocationController::class, 'create'])->middleware('auth:api')->name('create');
    Route::put('/{id}', [LocationController::class, 'update'])->middleware('auth:api')->name('update');
    Route::delete('/{id}', [LocationController::class, 'delete'])->middleware('auth:api')->name('delete');
});

Route::group(['middleware' => 'api', 'prefix' => 'item'], function () {
    Route::get('/', [ItemController::class, 'list'])->middleware('auth:api')->name('list');
    Route::get('/{id}', [ItemController::class, 'filterList'])->middleware('auth:api')->name('filterList');
    Route::post('/', [ItemController::class, 'create'])->middleware('auth:api')->name('create');
    Route::put('/{id}', [ItemController::class, 'update'])->middleware('auth:api')->name('update');
    Route::delete('/{id}', [ItemController::class, 'delete'])->middleware('auth:api')->name('delete');
});

Route::group(['middleware' => 'api', 'prefix' => 'mutation'], function () {
    Route::get('/', [MutationController::class, 'list'])->middleware('auth:api')->name('list');
    Route::get('/mutation-item/{id}', [MutationController::class, 'showByItem'])->middleware('auth:api')->name('showByItem');
    Route::get('/mutation-user/{id}', [MutationController::class, 'showByUser'])->middleware('auth:api')->name('showByUser');
    Route::get('/{id}', [MutationController::class, 'filterList'])->middleware('auth:api')->name('filterList');
    Route::post('/', [MutationController::class, 'create'])->middleware('auth:api')->name('create');
    Route::put('/{id}', [MutationController::class, 'update'])->middleware('auth:api')->name('update');
    Route::delete('/{id}', [MutationController::class, 'delete'])->middleware('auth:api')->name('delete');
});
