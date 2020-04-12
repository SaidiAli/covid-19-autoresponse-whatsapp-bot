<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

class OutBoundMessageController extends Controller
{
    protected $sandbox_numbers = [
        '+256777343212', '+256750783581'
    ];

    public function index() {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token );

        $response = Http::get('https://api.covid19api.com/summary')->json();

        foreach ($response['Global'] as $key => $value) {
            $msg[] = $key.' : '. $value . "\n";
        }
        $message = "Here is the summary for the covid-19 situation as of today: \n" . implode("\n", $msg);

        foreach($this->sandbox_numbers as $value) {
            $message = $twilio->messages->create(
                'whatsapp:'.$value,
                [
                    'from' => 'whatsapp:+14155238886',
                    'body' => $message
                ]
            );

            $message->sid;
        }
    }
}