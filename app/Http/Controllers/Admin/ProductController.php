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
        $id=$request->productID;
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
            'kdv'=>$request->kdv,
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
            'kdv'=>$request->kdv,
            'image'=>$product->image ?? $request->image,
            'status'=>$status,
        ]);
        return back()->withSuccess('Başarıyla Güncellendi!');
    }



    public function destroy($id)
    {
        try {
            $item = Product::find($id);
            if (!$item) {
                return response()->json(['error' => true, 'message' => 'Ürün bulunamadı.']);
            }

            deleteFile($item->image);
            $item->delete();

            return response()->json(['error' => false, 'message' => 'Ürün başarıyla silindi.']);
        } catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
    }
/* public function destroy($id)
    {
        $item = Product::find($id);
        deleteFile($item->image);
        $item->delete();
        return redirect()->route('product.index')->with([
            'success' => true,
            'error' => false,
        ]);

    }*/
    /*    public function destroy($id)
    {

        try {
            $item=Product::find($id);
            if ($item){
                if ($item->hasFile('image')){
                    deleteFile($item->image);
                }
                $item->delete();
            }
        }
        catch (\Exception $exception){
            return response()->json(['errorMessage' => $exception->getMessage()], 500);
        }
        return response()->json(['success' => true], 200);

    }*/

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
