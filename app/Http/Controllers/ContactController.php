<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\EmailDemo;
// use Mail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($request->all());exit;
        $email = $request->email;
        $message = $request->message;
        $subject = $request->subject;
        Contact::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'subject'=>$request->subject,
            'phone_no'=>$request->company_name,
            'message'=>$request->message,
            'status'=>"active",
        ]);

        $data = array('name'=>"Chandani");
        // print_r($email);exit;

        // $subject = 
        $email = $request->email;
   
        $mailData = [
            'title' => $request->title,
            'body' => $request->message
        ];
  
        Mail::to($email)->send(new EmailDemo($mailData));
   
        return redirect('contact/index');
    }
    //   Mail::send([],$data, function($message) use($request,$data) {
    //      $message->to($request->email, $request->message)->subject
    //         ($request->subject);
    //      $message->from(env('MAIL_USERNAME'),'chandani');
    //      $message->attachData($request->message, $request->name);
    //   });
        // return redirect('contact/index');
    // }

    
}
