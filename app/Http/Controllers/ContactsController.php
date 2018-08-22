<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\ContactusMail;
use Illuminate\Support\Facades\Mail;

use App\Contact;
use App\Category;
use App\Error;
use Validator;


use App\JSONResponse\JSONResponse;

class ContactsController extends Controller
{
    
    public function store(Request $request, Contact $saveContactusMessage){

        if($request->isMethod('post')){
        
        //validate request
        $this->validateContactusMessage($request);
        //$this->validateMessage($request);
        
        //then save
        $this->saveMessage($request, $saveContactusMessage);

        //then send mail
        $this->sendMail($request);

        //redirect back to contactus page
        return $this->normalResponse();

        //returns json response
        //return $this->jsonSuccessResponse('Message Sent.Thanks');
        
    }
        
        $allCategories = Category::all();
        return view('contactus')->with(compact('allCategories'));
    }

    public function validateContactusMessage(Request $request){

        $request->validate([

            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
            'phonenumber' => 'required|numeric',
        
        ]);
    }

    
    public function validateMessage(Request $request){
        $messages = [
            'name.required' => 'Please fill in the name field Thanks',
            'email.required' => 'Please fill in the email field Thanks',
            'message.required' => 'Please fill in the message field Thanks',
            'phonenumber.required' => 'Please fill in the phone field Thanks',
            'message.between' => 'The attribute must be one ',
        ];

        $rules = [
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|min:4|string',
            'phonenumber' => 'required|numeric',
        ];

        return $validator = Validator::make($request->all(), $rules, $messages)->validate();
    }


    public function saveMessage($request, Contact $saveContactusMessage){

        $saveContactusMessage = new Contact;
        $saveContactusMessage->name = $request->name;
        $saveContactusMessage->email = $request->email;
        $saveContactusMessage->message = $request->message;
        $saveContactusMessage->phonenumber = $request->phonenumber;

        $saveContactusMessage->save();

    }

    public function getContactusMessages(){
        $contactusMessages = Contact::all();
        //echo "<pre>"; print_r($contactusMessages); die;
        return $this->jsonSuccessResponse($contactusMessages);
    }

    public function jsonSuccessResponse($message){
        return response()->json([
            'Success' => $message
        ]);
    }
    
    public function normalResponse(){
        return redirect()->back()->with('success', 'Message Sent Successfully');
    }

   
    public function sendMail($request){
        return Mail::to($request)->send(new ContactusMail($request));
    }
}