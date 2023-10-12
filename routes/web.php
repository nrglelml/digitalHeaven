<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Front\PageHomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomController;


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

    Route::match(['GET','POST'],'/cart',[CartController::class,'index'])->name('cart');
    Route::get('/cart/form',[CartController::class,'cartForm'])->name('cart.form');
    Route::post('/cart/add',[CartController::class,'add'])->name('cart.add');
   // Route::post('/cart/remove',[CartController::class,'remove'])->name('cart.remove');
    Route::post('/cart/newqty',[CartController::class,'newqty'])->name('cart.newqty');
    Route::post('/cart/save',[CartController::class,'cartSave'])->name('cart.save');


    Route::post('/coupon',[CartController::class,'couponCheck'])->name('coupon.check');
    Auth::routes();
    Route::get('/logout',[AjaxController::class,'logout'])->name('logout');
});






