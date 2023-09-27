<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;

class AjaxController extends Controller
{
    public function contactStore(ContactFormRequest $request){
        $status =0;
        try {
            Contact::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'subject'=>$request->subject,
                'message'=>$request->message,
                'status'=>$status,
                'ip'=>$request->ip(),

            ]);
            return redirect()->back()->with('success', 'Başarıyla gönderildi. En kısa zamanda yanıtlanacak:).');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Mesaj gönderilirken bir hata oluştu: ' . $e->getMessage());
        }

    }
}
