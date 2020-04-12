<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

class OutBoundMessageController extends Controller
{
    public function index() {
        $sid = "AC692ec0f20baeaaa540be376063dc8149";
        $token = "6961004c5a711cc1683c69664c6b91ae";
        $twilio = new Client($sid, $token );

        $response = Http::get('https://api.covid19api.com/summary')->json();

        foreach ($response['Global'] as $key => $value) {
            $msg[] = $key.' : '. $value . "\n";
        }
        $message = "Here is a summary of the situation: " . implode("\n", $msg);

        $message = $twilio->messages->create(
            'whatsapp:+256777343212',
            [
                'from' => 'whatsapp:+14155238886',
                'body' => $message
            ]
            );

            return $message->sid;
    }
}