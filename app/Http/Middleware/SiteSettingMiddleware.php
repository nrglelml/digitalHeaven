<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use Closure;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SiteSettingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) :Response
    {

        $settings = SiteSetting::all()->pluck('data','name')->toArray();


        $categories = Category::where('status','1')->with('subcategory')->withCount('items')->get();


        view()->share(['settings'=>$settings,'categories'=>$categories]);

        return $next($request);
    }
}
