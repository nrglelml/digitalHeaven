<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;



class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();

        return view('admin.pages.slider.slider-list',compact('sliders'));
    }


    public function create()
    {
        return view('admin.pages.slider.slider-add');
    }


    public function store(SliderRequest $request)
    {
        $dosyaadi='';
        if ($request->hasFile('image')){
            $resim=$request->file('image');
            $dosyaadi= time().'-'.Str::slug($request->name);
            $uzanti=$resim->getClientOriginalExtension();
            $yukleKlasor='img/slider';
            if ($uzanti=='pdf'||$uzanti=='svg'||$uzanti=='webp'){
                $resim->move(public_path($yukleKlasor),$dosyaadi.'-'.$uzanti);
            }
            else{
                $resim= Image::make($resim);
                $resim->encode('webp',75)->save($yukleKlasor.$dosyaadi.'webp');

            }

        }
        Slider::create([
            'name'=>$request->name,
            'link'=>$request->link,
            'description'=>$request->description,
            'status'=>$request->status,
            'image'=>$dosyaadi ?? NULL,

        ]);
        return back()->withSuccess('Başarıyla Oluşturuldu');
    }


    public function show(string $id)
    {

    }


    public function edit(string $id)
    {
        $slider = Slider::where('id',$id)->with('images')->get();
        return view('admin.pages.slider.slider-add',compact('slider'));
    }


    public function update(Request $request, string $id)
    {
        $slider = Slider::where('id',$id)->firstOrFail();

        $filename='';
        if ($request->hasFile('image')){
            deleteFile($slider->image);

            $image=$request->file('image');
            $filename= $request->name;
            $yukleKlasor='img/slider';
            $imageurl = addImage($image,$filename,$yukleKlasor);
        }


        $slider->update([
            'name'=>$request->name,
            'link'=>$request->link,
            'description'=>$request->description,
            'status'=>$request->status,
            'image'=>$imageurl ?? NULL,

        ]);


        return back()->withSuccess('Başarıyla Güncellendi!');
    }


    public function destroy(Request $request)
    {
        $slider = Slider::where('id',$request->id)->firstOrFail();

        /* $imageMedia = ImageMedia::where('model_name', 'Slider')->where('table_id', $slider->id)->first();

         if (!empty($imageMedia->data)) {
             foreach ($imageMedia->data as $img) {
                 //dosyasil($img['image']);
             }
             $imageMedia->delete();
         }*/
        deleteFile($slider->image);
        $slider->delete();
        return response(['error'=>false,'message'=>'Başarıyla Silindi.']);
    }

    public function status(Request $request) {
        $update= $request->statu;
        $updateCheck= $update == true ? '1' : '0';
        Slider::where('id',$request->id)->update('status',$request->$updateCheck);
        return response(['error'=>false,'status'=>$update]);
    }
}

