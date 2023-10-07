<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use http\Cookie;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts= Contact::paginate(1);
        return view('admin.pages.contact.index',compact('contacts'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
       $contact= Contact::where('id',$id)->firstOrFail();
       return view('admin.pages.contact.edit',compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $update= $request->status;
        $updateCheck= $update == false ? '0' : '1';
        Contact::where('id',$id)->update(['status'=>$updateCheck]);
        return back()->withSuccess('Başarıyla Güncellendi');
    }


    public function destroy($id)
    {
        $contact = Contact::where('id',$id)->firstOrFail();

        $contact->delete();
        return response(['error'=>false,'message'=>'Başarıyla Silindi.']);
    }

    public function status(Request $request) {
        $update= $request->statu;
        $updateCheck= $update == false ? '0' : '1';
        Contact::where('id',$request->id)->update(['status'=>$updateCheck]);
        return response(['error'=>false,'status'=>$update]);
    }
}
