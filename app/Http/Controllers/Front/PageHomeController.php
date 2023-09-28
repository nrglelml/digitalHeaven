<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Category;
use App\Models\Slider;
use Database\Seeders\SliderSeeder;
use Illuminate\Http\Request;

class PageHomeController extends Controller
{
    public function home(){
       $slider= Slider::where('status',1)->first();
        $about_us=AboutUs::where('id',1)->first();
       return view('front.pages.home',compact('slider','about_us'));
    }
}
