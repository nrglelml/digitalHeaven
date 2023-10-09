<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $this->validate($request,
            ['image' => 'mimes:jpeg,jpg,png',],
            ['image.mimes' => 'Seçilen resim yalnızca .jpeg, .jpg, .png uzantılı olabilir.',]);
        $status = 0;
        if (isset($request->status)){
            $status = 1;
        }
        $category = Category::create([
            'name'=>$request->name,
            'cat_alt'=>$request->cat_alt,
            'description'=>$request->description,
            'status'=>$status,
            'image'=>$dosyaadi ?? NULL,

        ]);
        if ($request->file('image'))
        {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileOriginalName = $file->getClientOriginalName();
            $explode = explode('.', $fileOriginalName);
            $fileOriginalName = Str::slug($explode[0], '-') . '_' . now()->format('d-m-Y_H-i-s') . '.' . $extension;

            Storage::putFileAs('public/category', $file, $fileOriginalName);
            $category->image = 'category/' . $fileOriginalName;

        }
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
        $status = 0;
        if (isset($request->status)){
            $status = 1;
        }
        $this->validate($request,
            ['image' => 'mimes:jpeg,jpg,png',],
            ['image.mimes' => 'Seçilen resim yalnızca .jpeg, .jpg, .png uzantılı olabilir.',]);
        $category=Category::where('id',$id)->firstOrFail();
        if ($request->hasFile('image')){
            deleteFile($category->image);
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileOriginalName = $file->getClientOriginalName();
            $explode = explode('.', $fileOriginalName);
            $fileOriginalName = Str::slug($explode[0], '-') . '_' . now()->format('d-m-Y_H-i-s') . '.' . $extension;

            Storage::putFileAs('public/category', $file, $fileOriginalName);
            $category->image = 'category/' . $fileOriginalName;

        }


        $category->update([
            'name'=>$request->name,
            'link'=>$request->link,
            'description'=>$request->description,
            'status'=>$status,
            'image'=>$category->image ?? $request->image ,

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

    public function status($id) {
        $item = Category::find($id);

        if (!$item) {
            return abort(404);
        }

        $item->update(['status' => !$item->status]);
        return redirect()->route('category.index')->with([
            'success' => true,
            'error' => false,
        ]);
    }
}
