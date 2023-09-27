<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $category=Category::all();
        return view('admin.pages.category.category-list',compact('category'));
    }
    public function addShow(Request $request){
        $id=$request->categoryID;
        $category=null;
        if(!(is_null($id))){
            $category=Category::find($id);
        }
        return view('admin.pages.category.category-add',compact('category'));

    }
    public function add(Request $request){
        $status = 0;
        $this->validate(request(),[
            'name' => 'required',

        ]);
        if (isset($request->status)){
            $status = 1;
        }
        if (isset($request->categoryID))
        {
            $id = $request->categoryID;
            $category= Category::where("id",$request->categoryID)
                ->update([
                    "name"=>$request->name,
                    "cat_alt"=>$request->cat_alt,
                    "description"=>$request->description,
                    "status"=>$status,
                ]);

            return back()->withSuccess('Başarıyla Güncellendi!');
        }
        else{
            Category::create([
                "name"=>$request->name,
                "cat_alt"=>$request->cat_alt,
                "description"=>$request->description,
                "status"=>$status,

            ]);

            return back()->withSuccess('Başarıyla Güncellendi!');
        }
    }
    public function changeStatus($id){

    }
    public function delete($id){

    }



}
