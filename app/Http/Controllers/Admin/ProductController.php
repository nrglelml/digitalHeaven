<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\PreInc;

class ProductController extends Controller
{

    public function index()
    {
        $products=Product::paginate(20);
        return view('admin.pages.products.index',compact('products'));
    }


    public function create(Request $request)
    {
        $id=$request->id;
        $product=null;
        if (!is_null($id)){
            $product=Product::find($id);
        }
        return view('admin.pages.products.edit',compact('product'));

    }

    public function store(Request $request)
    {
        $this->validate($request,
            ['image' => 'mimes:jpeg,jpg,png',],
            ['image.mimes' => 'Seçilen resim yalnızca .jpeg, .jpg, .png uzantılı olabilir.',]);
        $status = 0;
        if (isset($request->status)){
            $status = 1;
        }
        $product =Product::create([
            'name'=>$request->name,
            'category_id'=>$request->category_id,
            'description'=>$request->description,
            'short_text'=>$request->short_text,
            'price'=>$request->price,
            'color'=>$request->color,
            'quantity'=>$request->quantity,
            'status'=>$status,
        ]);
        if ($request->file('image'))
        {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileOriginalName = $file->getClientOriginalName();
            $explode = explode('.', $fileOriginalName);
            $fileOriginalName = Str::slug($explode[0], '-') . '_' . now()->format('d-m-Y_H-i-s') . '.' . $extension;

            Storage::putFileAs('public/products', $file, $fileOriginalName);
            $product->image = 'products/' . $fileOriginalName;

        }
        return back()->withSuccess('Başarıyla Oluşturuldu');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $product=Product::find($id);
        return view('admin.pages.products.edit',compact('product'));

    }


    public function update(Request $request, $id)
    {
        $status = 0;
        if (isset($request->status)){
            $status = 1;
        }
        $this->validate($request,
            ['image' => 'mimes:jpeg,jpg,png',],
            ['image.mimes' => 'Seçilen resim yalnızca .jpeg, .jpg, .png uzantılı olabilir.',]);
        $product=Product::where('id',$id)->firstOrFail();
        if ($request->hasFile('image')){
            deleteFile($product->image);
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileOriginalName = $file->getClientOriginalName();
            $explode = explode('.', $fileOriginalName);
            $fileOriginalName = Str::slug($explode[0], '-') . '_' . now()->format('d-m-Y_H-i-s') . '.' . $extension;

            Storage::putFileAs('public/products', $file, $fileOriginalName);
            $product->image = 'products/' . $fileOriginalName;

        }
        $product->update([
            'name'=>$request->name,
            'category_id'=>$request->category_id,
            'description'=>$request->description,
            'short_text'=>$request->short_text,
            'price'=>$request->price,
            'color'=>$request->color,
            'quantity'=>$request->quantity,
            'status'=>$status,
        ]);
    }


    public function destroy($id)
    {
        $item = Product::find($id);

        $item->delete();


        return redirect()->route('product.index')->with([
            'success' => true,
            'error' => false,
        ]);
    }

    public function status($id){
        $item = Product::find($id);

        if (!$item) {
            return abort(404);
        }

        $item->update(['status' => !$item->status]);
        return redirect()->route('product.index')->with([
            'success' => true,
            'error' => false,
        ]);
    }
}
