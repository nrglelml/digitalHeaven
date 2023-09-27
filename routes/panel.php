<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'panelsetting' , 'prefix'=>'admin' , 'as'=>'admin'],function (){
    Route::get('/', [SliderController::class, 'index'])->name('admin');
    Route::prefix('/category')->group(function (){
        Route::get('/list',[CategoryController::class,'index'])->name('category-list');
        Route::get('/add',[CategoryController::class,'addShow'])->name('category-add');
        Route::post('/add',[CategoryController::class,'add']);
    });

});

