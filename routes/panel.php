<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SiteSettingController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['panelsetting','auth'] , 'prefix'=>'admin' ],function (){

    Route::resource('slider', SliderController::class);
    Route::delete('slider/delete',[SliderController::class,'destroy'])->name('slider.destroy');
    Route::get('/slider-status/{id}',[SliderController::class,'status'])->name('slider.status');

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
    Route::get('/category-status/{id}',[CategoryController::class,'status'])->name('category.status');

   // Route::resource('product', ProductController::class);
    Route::match(['GET','POST','DELETE'],'/product',[ProductController::class,'index'])->name('product.index');
    Route::get('/product/create',[ProductController::class,'create'])->name('product.create');
    Route::get('/product/edit/{id}',[ProductController::class,'edit'])->name('product.edit');
    Route::post('/product/store',[ProductController::class,'store'])->name('product.store');
    Route::put('/product/update/{id}',[ProductController::class,'update'])->name('product.update');
    Route::delete('/product/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/product-status/{id}',[ProductController::class,'status'])->name('product.status');


    Route::prefix('about')->group(function (){
       Route::get('/',[AboutController::class,'index'])->name('about.index');
        Route::post('/update',[AboutController::class,'update'])->name('about.update');
    });
    Route::resource('contact', ContactController::class);
    Route::get('/contact-status/{id}',[ContactController::class,'status'])->name('contact.status');

    Route::prefix('setting')->group(function (){
        Route::get('/',[SiteSettingController::class,'index'])->name('setting.index');
        Route::match(['GET','POST'],'/create',[SiteSettingController::class,'create'])->name('setting.create');
        Route::post('/store',[SiteSettingController::class,'store'])->name('setting.store');
        Route::get('/edit',[SiteSettingController::class,'edit'])->name('setting.edit');
        Route::put('/update/{id}',[SiteSettingController::class,'update'])->name('setting.update');
        Route::get('/destroy/{id}',[SiteSettingController::class,'destroy'])->name('setting.destroy');
    });


});

