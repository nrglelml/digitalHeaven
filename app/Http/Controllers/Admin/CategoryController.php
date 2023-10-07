<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{

    protected $model = Category::class;

    public function index()
    {
        $categories = Category::with('subcategory:id,cat_alt,name')->get();

        return view('admin.pages.category.category-list',compact('categories'));
    }


    public function create()
    {
        $categories = Category::where('cat_alt',null)->get();
        return view('admin.pages.category.category-add',compact('categories'));
    }


    public function store(CategoryRequest $request)
    {
        $dosyaadi='';
        if ($request->hasFile('image')){
            $resim=$request->file('image');
            $dosyaadi= time().'-'.Str::slug($request->name);
            $uzanti=$resim->getClientOriginalExtension();
            $yukleKlasor='img/category';
            if ($uzanti=='pdf'||$uzanti=='svg'||$uzanti=='webp'){
                $resim->move(public_path($yukleKlasor),$dosyaadi.'-'.$uzanti);
            }
            else{
                $resim= Image::make($resim);
                $resim->encode('webp',75)->save($yukleKlasor.$dosyaadi.'webp');

            }

        }
        category::create([
            'name'=>$request->name,
            'cat_alt'=>$request->cat_alt,
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
        $category = Category::where('id',$id)->first();
        return view('admin.pages.category.category-add',compact('category'));
    }


    public function update(Request $request, string $id)
    {
        $category = Category::where('id',$id)->firstOrFail();
        $imageurl = $category->image;

        $filename='';
        if ($request->hasFile('image')){
            deleteFile($category->image);

            $image=$request->file('image');
            $filename= $request->name;
            $yukleKlasor = public_path('img/category');
            $imageurl = addImage($image,$filename,$yukleKlasor);
        }


        $category->update([
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
        $category = Category::find($id);
        //$category = category::where('id',$request->id)->firstOrFail();
       // deleteFile($category->image);
        $category->delete();
        return response(['error'=>false,'message'=>'Başarıyla Silindi.']);
    }

    public function status(Request $request) {
        $update= $request->statu;
        $updateCheck= $update == false ? '0' : '1';
        Category::where('id',$request->id)->update(['status'=>$updateCheck]);
        return response(['error'=>false,'status'=>$update]);
    }
}
