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
    protected $model = Slider::class;

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
        $filename='';
        if ($request->hasFile('image')){
            $image=$request->file('image');
            $filename= time().'-'.Str::slug($request->name);
            $extension=$image->getClientOriginalExtension();
            $yukleKlasor='img/slider';
            if ($extension=='pdf'||$extension=='svg'||$extension=='webp'){
                $image->move(public_path($yukleKlasor),$filename.'-'.$extension);
            }
            else{
                $resim= Image::make($image);
                $resim->encode('webp',75)->save($yukleKlasor.$filename.'webp');

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
        $slider = Slider::where('id',$id)->first();
        return view('admin.pages.slider.slider-add',compact('slider'));
    }


    public function update(Request $request, string $id)
    {
        $slider = Slider::where('id',$id)->firstOrFail();
        $imageurl = $slider->image;

        $filename='';
        if ($request->hasFile('image')){
            deleteFile($slider->image);

            $image=$request->file('image');
            $filename= $request->name;
            $yukleKlasor = public_path('img/slider');
            $imageurl = addImage($image,$filename,$yukleKlasor);
        }


        $slider->update([
            'name'=>$request->name,
            'link'=>$request->link,
            'description'=>$request->description,
            'status'=>$request->status,
            'image'=>$imageurl ,

        ]);


        return back()->withSuccess('Başarıyla Güncellendi!');
    }


    public function destroy(Request $request)
    {
        $id=$request->id;
        $slider = Slider::find($id);
        //$slider = Slider::where('id',$request->id)->firstOrFail();
        deleteFile($slider->image);
        $slider->delete();
        return response(['error'=>false,'message'=>'Başarıyla Silindi.']);
    }

    public function status(Request $request) {
        $update= $request->statu;
        $updateCheck= $update == false ? '0' : '1';
        Slider::where('id',$request->id)->update(['status'=>$updateCheck]);
        return response(['error'=>false,'status'=>$update]);
    }
}

