<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Mail;

class ContactUsFormController extends Controller
{
    public function createForm(Request $request) {
        return view('home');
      }
      // Store Contact Form data
      public function ContactUsForm(Request $request) {
          // Form validation
          $this->validate($request, [
              'name' => 'required',
              'email' => 'required|email',
              'message' => 'required'
           ]);
          //  Store data in database
          Contact::create($request->all());
        //    print_r($request);
           //  Send mail to admin
        \Mail::send('mail', array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'user_query' => $request->get('message'),
        ), function($message) use ($request){
            $message->from($request->email);
            $message->to('info@dhntechno.com', 'Admin');
        });
          return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
      }
}
