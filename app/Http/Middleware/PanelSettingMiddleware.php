<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use Closure;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class PanelSettingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $settings = SiteSetting::all()->pluck('data','name')->toArray();



        view()->share(['settings'=>$settings]);

        return $next($request);
    }
}
