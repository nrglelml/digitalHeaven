<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['panelsetting','auth'] , 'prefix'=>'admin' ],function (){
    Route::group(['as'=>'slider.'], function (){
        Route::resource('/', SliderController::class);
        Route::get('/slider-status',[SliderController::class,'status'])->name('status');
        Route::post('/slider-status',[SliderController::class,'status'])->name('status');
        Route::get('/slider-status',[SliderController::class,'status'])->name('status');
    });
   /* Route::group(['as'=>'category.'], function (){
        Route::resource('/', CategoryController::class);
        Route::get('/slider-status',[CategoryController::class,'status'])->name('status');
    });*/


});

