<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
    public function add(Request $request)
    {
        $productID = $request->product_id;
        $quantity = $request->qty ?? 1;
        $color = $request->color;

        $product = Product::find($productID);

        if (!$product) {
            return back()->withErrors("Ürün Bulunamadı");
        }

        $cartItem = session('cart', []);

        if (array_key_exists($productID, $cartItem)) {
            $cartItem[$productID]['quantity'] += $quantity;
        } else {
            $cartItem[$productID] = [
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => $quantity,
                'color' => $color,
            ];
        }

        session(['cart' => $cartItem]);

        return back()->withSuccess("Ürün Sepete Eklendi");
    }


    public function remove(Request $request){
        $productID = $request->product_id;
        $cartItem = session('cart', []);
        if (array_key_exists($productID, $cartItem)) {
            unset($cartItem[$productID]);
        }
        session(['cart' => $cartItem]);
        return back()->withSuccess("Ürün Sepetten Çıkarıldı");
    }

}
