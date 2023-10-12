<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Order;
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
    public function cartForm(){
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
        return view('front.pages.cartForm',compact('cartItem'));
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
                'kdv' => $product->kdv
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
        session()->put('coupon_price',$couponprice);
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
        if(array_key_exists($productID,$cartItem)){
            $cartItem[$productID]['quantity'] = $quantity;
            if($quantity== 0 || $quantity < 0){
                unset($cartItem[$productID]);
            }
            $itemtotal = $product->price * $quantity;
        }

        session(['cart' => $cartItem]);

        $cartItem=session()->get('cart');
        $totalPrice=0;
        foreach ($cartItem as $cart){
            $totalPrice +=$cart['price'] * $cart['quantity'];
        }

        if(session()->get('coupon_code')){
           $coupon= Coupon::where('name',session()->get('coupon_code'))->where('status',1)->first();
           $couponPrice=$coupon->price ?? 0;

           $newTotalPrice =$totalPrice - $couponPrice;
        }
        else{
            $newTotalPrice =$totalPrice;
        }

        session()->put('totalPrice',$totalPrice);

        if ($request->ajax()) {
            return response()->json(['itemTotal' => $itemtotal,'totalPrice'=>session()->get('total_price'), 'message' => 'Sepet Güncellendi']);
        }
    }
    function generateKod(){
        $orderno=generateOTP(7);
        if ($this->barcodeKodExist($orderno)){
            return Invoice::where('order_no',$orderno)->exists();
        }
        return $orderno;
    }
    function barcodeKodExist($orderno){
        return Invoice::where('order_no',$orderno)->exists();
    }
    public function cartSave(Request $request){
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required|string',
            'company_name' => 'nullable|string',
            'address' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'zip_code' => 'required|string',
            'note' => 'nullable|string',
        ],[
            'name.required' => __('İsim alanı zorunludur.'),
            'name.string' => __('İsim bir metin olmalıdır.'),
            'name.min' => __('İsim en az 3 karakterden oluşmalıdır.'),
            'email.required' => __('E-posta alanı zorunludur.'),
            'email.email' => __('Geçerli bir e-posta adresi girilmelidir.'),
            'phone.required' => __('Telefon alanı zorunludur.'),
            'phone.string' => __('Telefon bir metin olmalıdır.'),
            'company_name.string' => __('Şirket adı bir metin olmalıdır.'),
            'address.required' => __('Adres alanı zorunludur.'),
            'address.string' => __('Adres bir metin olmalıdır.'),
            'country.required' => __('Ülke alanı zorunludur.'),
            'country.string' => __('Ülke bir metin olmalıdır.'),
            'city.required' => __('Şehir alanı zorunludur.'),
            'city.string' => __('Şehir bir metin olmalıdır.'),
            'district.required' => __('İlçe alanı zorunludur.'),
            'district.string' => __('İlçe bir metin olmalıdır.'),
            'zip_code.required' => __('Posta kodu alanı zorunludur.'),
            'zip_code.string' => __('Posta kodu bir metin olmalıdır.'),
            'note.string' => __('Not bir metin olmalıdır.'),
        ]);

        $invoce = Invoice::create([
            "user_id"=> auth()->user()->id ?? null,
            "order_no"=> $this->generateKod(),
            "country"=> $request->country,
            "name"=> $request->name,
            "company_name"=> $request->company_name ?? null,
            "address"=> $request->address ?? null,
            "city"=> $request->city ?? null,
            "district"=> $request->district ?? null,
            "zip_code"=> $request->zip_code ?? null,
            "email"=> $request->email ?? null,
            "phone"=> $request->phone ?? null,
            "note"=> $request->note ?? null,
        ]);


        $cart = session()->get('cart') ?? [];
        foreach ( $cart as $key => $item) {
            Order::create([
                'order_no'=> $invoce->order_no,
                'product_id'=>$key,
                'name'=>$item['name'],
                'price'=>$item['price'],
                'quantity'=>$item['quantity'],
                'kdv'=>$item['kdv']
            ]);
        }

        session()->forget('cart');
        return redirect()->route('home')->withSuccess('Alışveriş Başarıyla Tamamlandı.');
    }


}
