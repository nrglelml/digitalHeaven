<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['panelsetting','auth'] , 'prefix'=>'admin' ],function (){

    Route::resource('slider', SliderController::class);
    Route::delete('slider/delete',[SliderController::class,'destroy'])->name('slider.destroy');
    Route::get('/slider-status',[SliderController::class,'status'])->name('slider.status');

/*
    Route::group(['as'=>'slider.'], function (){
        Route::resource('/', SliderController::class);
        Route::get('/slider-status',[SliderController::class,'status'])->name('status');
        Route::post('/slider-edit2/{id}',[SliderController::class,'update'])->name('update');
        Route::get('/slider-edit/{id}',[SliderController::class,'edit'])->name('edit');
        Route::post('/slider-status',[SliderController::class,'status']);
    });
*/
    Route::resource('category', CategoryController::class);
    Route::get('/category-status',[CategoryController::class,'status'])->name('category.status');

    Route::prefix('about')->group(function (){
       Route::get('/',[AboutController::class,'index'])->name('about.index');
        Route::post('/update',[AboutController::class,'update'])->name('about.update');
    });
    Route::resource('contact', ContactController::class);
    Route::get('/contact-status',[ContactController::class,'status'])->name('contact.status');



});

