<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Front\PageHomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CartController;


Route::middleware('sitesetting')->group(function (){
    Route::get('/',[PageHomeController::class,'home'])->name('home');
    Route::get('/products',[PageController::class,'products'])->name('products');
    Route::get('/bilgisayar/{slug?}',[PageController::class,'products'])->name('bilgisayarürün');
    Route::get('/telefon/{slug?}',[PageController::class,'products'])->name('telefonürün');
   // Route::get('/apple/{slug?}',[PageController::class,'products'])->name('appleürün');
  //  Route::get('/kulaklık/{slug?}',[PageController::class,'products'])->name('kulaklikürün');
    Route::get('/products_detail/{slug}',[PageController::class,'products_detail'])->name('products_detail');
    Route::get('/sale_products',[PageController::class,'sale_products'])->name('sale_products');
    Route::get('/aboutus',[PageController::class,'aboutus'])->name('aboutus');
    Route::get('/contact',[PageController::class,'contact'])->name('contact');
    Route::post('/contact/store',[AjaxController::class,'contactStore'])->name('contact.store');
    Route::get('/cart',[CartController::class,'index'])->name('cart');
    Route::post('/cart',[CartController::class,'add'])->name('cart.add');
});


Route::prefix('/admin')->group(function (){
    Route::get('/', [SliderController::class, 'index'])->name('admin');
    Route::prefix('/category')->group(function (){
        Route::get('/list',[CategoryController::class,'index'])->name('category-list');
        Route::get('/add',[CategoryController::class,'addShow'])->name('category-add');
        Route::post('/add',[CategoryController::class,'add']);
    });

});
