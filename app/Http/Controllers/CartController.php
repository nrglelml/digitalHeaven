<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
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
        if (session()->get('coupon_code')){
            $coupon=Coupon::where('name',session()->get('coupon_code'))->where('status',1)->first();
            $couponprice=$coupon->price ?? 0;
            $couponcode=$coupon->name ?? '';
            $newtotalPrice=$totalPrice - $couponprice;
        }
        else{
            $newtotalPrice=$totalPrice;
        }
        session()->put('total_price',$newtotalPrice);
        return view('front.pages.cart',compact('cartItem'));
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

    public function couponCheck(Request $request)
    {

        $cartItem= session('cart',[]);
        $totalPrice= 0;
        foreach ($cartItem as $cart){
            $totalPrice +=$cart['price'] * $cart['quantity'];
        }
        $coupon=Coupon::where('name',$request->name)->where('status',1)->first();
        if (empty($coupon)){
            return back()->withErrors('Kupon Bulunamadı');
        }
        $couponprice=$coupon->price ?? 0;
        $couponcode=$coupon->name ?? '';

        $newtotalPrice=$totalPrice - $couponprice;

        session()->put('total_price',$newtotalPrice);
        session()->put('coupon_code',$couponcode);
        return back()->withSuccess("Kupon Uygulandı");
    }

    public function newqty(Request $request) {
        $productID = $request->product_id;
        $quantity = $request->qty ?? 1;

        $product = Product::find($productID);

        if (!$product) {
            return back()->withErrors("Ürün Bulunamadı");
        }

        $cartItem = session('cart', []);

        if (array_key_exists($productID, $cartItem)) {
            $cartItem[$productID]['quantity'] = $quantity;
            $itemtotal = $product->price * $quantity; // Ürün miktarının güncellenmiş toplam fiyatını hesaplayın
        }

        session(['cart' => $cartItem]);

        if ($request->ajax()) {
            return response()->json(['itemTotal' => $itemtotal, 'message' => 'Sepet Güncellendi']);
        }
    }
/*
 public function newqty(Request $request) {
        $productID = $request->product_id;
        $quantity = $request->qty ?? 1;

        $product = Product::find($productID);

        if (!$product) {
            return back()->withErrors("Ürün Bulunamadı");
        }

        $cartItem = session('cart', []);

        if (array_key_exists($productID, $cartItem)) {
            $cartItem[$productID]['quantity'] += $quantity;
        }
        $itemtotal= $product->price *$quantity;
        session(['cart' => $cartItem]);

        if($request->ajax()) {
            return response()->json(['itemTotal'=>$itemtotal,  'message'=>'Sepet Güncellendi']);
        }
    }
*/

}
