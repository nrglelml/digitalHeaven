<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        $cartItem= session('cart',[]);
        $totalPrice= 0;
        foreach ($cartItem as $cart){
            $totalPrice +=$cart['price'] * $cart['quantity'];
        }
        return view('front.pages.cart',compact('cartItem','totalPrice'));
    }
    public function add(Request $request){
        return $request->all();
    }

    public function remove(){

    }
}
