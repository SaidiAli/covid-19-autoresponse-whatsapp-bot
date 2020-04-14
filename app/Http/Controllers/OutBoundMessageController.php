<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;

class OutBoundMessageController extends Controller
{
    protected $sandbox_numbers = [
        '+256777343212'
    ];

    public function index() {
        return view('welcome');
    }

    public function send() {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TKN');
        $twilio = new Client($sid, $token );

        // Make http requests to corona virus data center.
        $corona_data_all = Http::get('https://corona.lmao.ninja/all')->json();
        $corona_data_ug = Http::get('https://corona.lmao.ninja/countries/uganda')->json();


        // process message template
        $msg = "Here is the summary for the covid-19 situation as of today (Global): \n" . "New Confirmed: " . $corona_data_all['todayCases'] . "\n Total Confirmed: " . $corona_data_all['cases'] . "\n New Deaths: " . $corona_data_all['todayDeaths'] . "\n Total Deaths: " . $corona_data_all['deaths'] . " \u{1F622}\n Recovered: " . $corona_data_all['recovered'] . "\xF0\x9F\x92\xAA" . " \n Active: " . $corona_data_all['active'] . "\n Critical: " . $corona_data_all['critical'] . "\n\n" . "Uganda Summary: \n New Confirmed: " . $corona_data_ug['todayCases'] . "\n Total Confirmed: " . $corona_data_ug['cases'] . "\n New Deaths: " . $corona_data_ug['todayDeaths'] . "\n Total Deaths: " . $corona_data_ug['deaths'] . "\n Total Recovered: " . $corona_data_ug['recovered'] . "\xF0\x9F\x92\xAA" . "\n\n _data by:_\n thevirustracker.com \n worldometers.info \u{1F30F}\n\n brought to you by yours truly: *Bonstana* \xF0\x9F\x98\x8E";

        foreach($this->sandbox_numbers as $corona_data_all) {
            $message = $twilio->messages->create(
                'whatsapp:'.$corona_data_all,
                [
                    'from' => 'whatsapp:+14155238886',
                    'body' => $msg
                ]
            );

        // Send out the message. 
        $message->sid;

        return view('message-sent');
        
        }
    }
}