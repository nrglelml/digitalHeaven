<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function products(Request $request, $slug=null){
        $category= request()->segment(1);
        $color =$request->color ?? null;
        $start_price =$request->start_price  ?? null;
        $end_price =$request->end_price  ?? null;

        $order=$request->order ?? 'id';
        $sort=$request->sort ?? 'desc';

        $products =Product::where('status',1)->select(['id','name','slug','color','price','category_id','image'])
            ->where(function ($q) use($color,$start_price ,$end_price){
                if (!empty($color)){
                    $q->where('color',$color);
                }
                if (!empty($start_price && $end_price)){
                    $q->whereBetween('price',[$start_price ,$end_price]);
                }
                return $q;
            })->with('category:id,name,slug')
            ->whereHas('category',function ($q) use( $category,$slug){
                if (!empty($slug)){
                    $q->where('slug',$slug);
                }
               /* if (!empty($category)){
                    $q->where('category',$category);
                }*/
                return $q;
            });


        $products= $products->orderBy($order,$sort)->paginate(21);
        $minprice= $products->min('price');
        $maxprice= $products->max('price');
        $colors= Product::where('status',1)->groupBy('color')->pluck('color')->toArray();



        return view('front.pages.products', compact('products','minprice','maxprice','colors'));
    }

    public function products_detail($slug){
        $products =Product::where('status',1)->where('slug',$slug)->firstOrFail();
        $product =Product::where('id','!=',$products->id)
            ->where('category_id',$products->category_id)
            ->limit(6)
            ->get();
        return view('front.pages.products_detail',compact('products','product'));
    }
    public function sale_products(){
        return view('front.pages.sale_products');
    }
    public function aboutus(){
        $about_us=AboutUs::where('id',1)->first();
        return view('front.pages.aboutus',compact('about_us'));
    }
    public function contact(){
        return view('front.pages.contact');
    }



}
