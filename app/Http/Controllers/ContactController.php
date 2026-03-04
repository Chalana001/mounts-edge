<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
public function sendEnquiry(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'type' => 'required|string',
            'message' => 'required|string'
        ]);

        $mailBody = "You have received a new {$data['type']} enquiry from the website:\n\n"
                  . "Name: {$data['name']}\n"
                  . "Email: {$data['email']}\n"
                  . "Phone: {$data['phone']}\n"
                  . "Inquiry Type: {$data['type']}\n"
                  . "Message:\n{$data['message']}\n";

        Mail::raw($mailBody, function ($message) use ($data) {
            $message->to('info@mountsedgeregency.com') 
                    ->replyTo($data['email']) 
                    ->subject("New {$data['type']} from {$data['name']}");
        });

        return back()->with('success', 'Thank you! Your inquiry has been sent successfully.');
    }
    public function notifyWhatsapp(Request $request)
    {
        $time = now()->format('Y-m-d H:i:s');
        
        Mail::raw("Someone clicked the WhatsApp chat button on the website at {$time}.", function ($message) {
            $message->to('info@mountsedgeregency.com')
                    ->subject('🟢 New WhatsApp Lead!');
        });
        return response()->json(['status' => 'success']);
    }
}