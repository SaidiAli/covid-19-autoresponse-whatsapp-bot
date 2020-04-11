<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class OutBoundMessageController extends Controller
{
    public function index() {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token );

        $message = $twilio->messages->create(
            'whatsapp:+256777343212',
            [
                'from' => 'whatsapp:+14155238886',
                'body' => 'Hello from twilio laravel'
            ]
            );

            return $message->sid;
    }
}