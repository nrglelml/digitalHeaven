<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiteSettingController extends Controller
{
    public function index(){
        $settings=SiteSetting::get();
        return view('admin.pages.site_setting.index',compact('settings'));
    }
    public function create(){
        return view('admin.pages.site_setting.edit');
    }

    public function store(Request $request){
        $key=$request->name;
        $setting=SiteSetting::where('name',$key)->first();
        if (empty($setting)){
            SiteSetting::create([
               'name'=>$key,
                'data'=>$request->data,
                'set_type'=>$request->set_type
            ]);
        }
        return back()->withSuccess('Başarıyla Oluşturuldu');
    }
    public function edit(Request $request){
        $id=$request->id;
        $setting=SiteSetting::find($id);
        return view('admin.pages.site_setting.edit',compact('setting'));
    }
    public function update(Request $request,$id){
        $setting = SiteSetting::find($id);

        $this->validate($request,
            ['image' => 'mimes:jpeg,jpg,png',],
            ['image.mimes' => 'Seçilen resim yalnızca .jpeg, .jpg, .png uzantılı olabilir.',]);
        if ($request->hasFile('data')){
            deleteFile($setting->image);
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileOriginalName = $file->getClientOriginalName();
            $explode = explode('.', $fileOriginalName);
            $fileOriginalName = Str::slug($explode[0], '-') . '_' . now()->format('d-m-Y_H-i-s') . '.' . $extension;

            Storage::putFileAs('public/site_setting', $file, $fileOriginalName);
            $setting->image = 'site_setting/' . $fileOriginalName;
        }


        $setting->update([
            'name'=>$request->name,
            'data'=>$imageurl ?? $request->data,
            'set_type'=>$request->set_type
        ]);
        return back()->withSuccess('Başarıyla Güncellendi');

    }
    public function destroy($id){
       $setting=  SiteSetting::find($id);
       $setting->delete();
        return back()->withSuccess('Başarıyla Silindi');
    }
}
