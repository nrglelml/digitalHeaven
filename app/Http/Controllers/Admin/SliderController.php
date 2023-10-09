<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $this->validate($request,
            ['image' => 'mimes:jpeg,jpg,png',],
            ['image.mimes' => 'Seçilen resim yalnızca .jpeg, .jpg, .png uzantılı olabilir.',]);
        $status = 0;
        if (isset($request->status)){
            $status = 1;
        }
        $slider = Slider::create([
            'name'=>$request->name,
            'link'=>$request->link,
            'description'=>$request->description,
            'status'=>$status,
            'image'=>$dosyaadi ?? NULL,

        ]);
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileOriginalName = $file->getClientOriginalName();
            $explode = explode('.', $fileOriginalName);
            $fileOriginalName = Str::slug($explode[0], '-') . '_' . now()->format('d-m-Y_H-i-s') . '.' . $extension;

            Storage::putFileAs('public/products', $file, $fileOriginalName);
            $slider->image = 'products/' . $fileOriginalName;

        }

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
        $status = 0;
        if (isset($request->status)){
            $status = 1;
        }
        $slider = Slider::where('id',$id)->firstOrFail();

        $this->validate($request,
            ['image' => 'mimes:jpeg,jpg,png',],
            ['image.mimes' => 'Seçilen resim yalnızca .jpeg, .jpg, .png uzantılı olabilir.',]);
        if ($request->hasFile('image')){
            deleteFile($slider->image);
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileOriginalName = $file->getClientOriginalName();
            $explode = explode('.', $fileOriginalName);
            $fileOriginalName = Str::slug($explode[0], '-') . '_' . now()->format('d-m-Y_H-i-s') . '.' . $extension;

            Storage::putFileAs('public/slider', $file, $fileOriginalName);
            $slider->image = 'slider/' . $fileOriginalName;

        }


        $slider->update([
            'name'=>$request->name,
            'link'=>$request->link,
            'description'=>$request->description,
            'status'=>$status,
            'image'=>$slider->image ?? $request->image,

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

    public function status($id) {
        $item = Slider::find($id);

        if (!$item) {
            return abort(404);
        }

        $item->update(['status' => !$item->status]);
        return redirect()->route('slider.index')->with([
            'success' => true,
            'error' => false,
        ]);
    }
}

