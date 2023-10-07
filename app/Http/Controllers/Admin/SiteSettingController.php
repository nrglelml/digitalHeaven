<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

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
        $setting=SiteSetting::where('id',$id)->first();
        return view('admin.pages.site_setting.edit',compact('setting'));
    }
    public function update(Request $request,$id){
        $setting=SiteSetting::where('id',$id)->first();

        $key=$request->name;

        if ($request->hasFile('data')){
            deleteFile($setting->data);

            $image=$request->file('data');
            $filename= time();
            $yukleKlasor = public_path('img/setting/');
            openFile($yukleKlasor);
            $imageurl = addImage($image,$filename,$yukleKlasor);
        }


        $setting->update([
            'name'=>$key,
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
