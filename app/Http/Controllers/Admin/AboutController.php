<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    public function index(){
        $about=AboutUs::where('id',1)->first();
        return view('admin.pages.about.index',compact('about'));
    }
    public function update(Request $request, $id =1){

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $request->name;
            $yukleKlasor = public_path('img/about');
            $resimurl=addImage($image,$filename,$yukleKlasor);
        }
            AboutUs::updateOrCreate(
                ['id' => $id],
                ['name' => $request->name,
                    'description' => $request->description,
                    'text_1_icon' => $request->text_1_icon,
                    'text_1_title' => $request->text_1_title,
                    'text_1_content' => $request->text_1_content,
                    'text_2_icon' => $request->text_2_icon,
                    'text_2_title' => $request->text_2_title,
                    'text_2_content' => $request->text_2_content,
                    'text_3_icon' => $request->text_3_icon,
                    'text_3_title' => $request->text_3_title,
                    'text_3_content' => $request->text_3_content,
                ]);


            return back()->withSuccess('Başarıyla Güncellendi!');
        }
}
