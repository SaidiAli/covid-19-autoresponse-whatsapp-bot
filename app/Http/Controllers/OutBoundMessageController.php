<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Twilio\Rest\Client;
use Illuminate\Support\Arr;
use Twilio\TwiML\MessagingResponse;

class OutBoundMessageController extends Controller
{
    // protected $sandbox_numbers = [
    //     '+256704672670', '+256781557769', '+256704642705', '+256759806865', '+256777343212', '+256753672882', '+256787911516', '+256781729644', '+256706818239', '+256750783581'
    // ];

    protected $sandbox_numbers = [
        '+256777343212', '+256753672882'
    ];

    public function index() {
        return view('welcome');
    }

    public function news() {
        try{
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TKN');
            $twilio = new Client($sid, $token);

            $us_news = Http::get('https://newsapi.org/v2/top-headlines?country=us&apiKey=' . env('NEWS_API_KEY') . '&q=coronavirus&category=health')->json();

            if ($us_news['status'] == 'ok') {
                // fetch a random article
                $article = collect($us_news['articles'])->random();

                $msg = "*NEWS HOURS*: \n\n *Headline:* \xF0\x9F\x91\x89" . $article['title'] . "\n\n" . $article['description'] . "\n\n Link: " . $article['url'] . "\n\n ``` Social Distancing is an opportunity to check if you can tolerate your own company - just a quote``` \n\n \xE2\x80\xBC Send ```news``` to get a news article anytime you feel like \n \xE2\x80\xBC Send ```hi or hello``` to get a helper menu\n *Stay Home, Stay Safe*";

                foreach ($this->sandbox_numbers as $contact) {
                    $message = $twilio->messages->create(
                        'whatsapp:'.$contact,
                        [
                            'from' => 'whatsapp:+14155238886',
                            'body' => $msg
                        ]
                    );
                    $message->sid;
                }
            } else {
                // send feedback
                $twilio->messages->create(
                    'whatsapp:+256753672882',
                    [
                        'from' => 'whatsapp:+14155238886',
                        'body' => "The newsApi just crushed, check it out .... !! Status is not ok"
                    ]
                )->sid;
            }

            return view('message-sent');
        } catch(Exception $e) {
            return response('An exception occured: '.$e->getMessage(), 500);
            // return view('welcome', ['exception' => $e->getMessage()]);
        }
    }

    public function updates() {
        try{
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TKN');
            $twilio = new Client($sid, $token);

            // Make http requests to corona virus data center.
            $corona_data_all = Http::get('https://corona.lmao.ninja/v2/all')->json();
            $corona_data_ug = Http::get('https://corona.lmao.ninja/v2/countries/uganda')->json();


            // process message template
            $msg = "Here is the summary for the covid-19 situation as of today (Global): \n\n" . "New Confirmed: " . $corona_data_all['todayCases'] . "\n Total Confirmed: " . $corona_data_all['cases'] . "\n New Deaths: " . $corona_data_all['todayDeaths'] . "\n Total Deaths: " . $corona_data_all['deaths'] . " \u{1F622}\n Recovered: " . $corona_data_all['recovered'] . "\xF0\x9F\x92\xAA" . " \n Active: " . $corona_data_all['active'] . "\n Critical: " . $corona_data_all['critical'] . "\n\n" . "Uganda Summary: \n New Confirmed: " . $corona_data_ug['todayCases'] . "\n Total Confirmed: " . $corona_data_ug['cases'] . "\n New Deaths: " . $corona_data_ug['todayDeaths'] . "\n Total Deaths: " . $corona_data_ug['deaths'] . "\n Total Recovered: " . $corona_data_ug['recovered'] . "\xF0\x9F\x92\xAA" . "\n\n \xE2\x80\xBC Send ```update``` to get this message again \n \xE2\x80\xBC Send ```hi or hello``` to get a helper menu \n\n _data by:_\n thevirustracker.com \n worldometers.info \u{1F30F}\n\n brought to you by yours truly: *Bonstana* \xF0\x9F\x98\x8E";

            foreach($this->sandbox_numbers as $contact) {
                $message = $twilio->messages->create(
                    'whatsapp:'.$contact,
                    [
                        'from' => 'whatsapp:+14155238886',
                        'body' => $msg
                    ]
                );

            // Send out the message. 
            $message->sid;
            }

            return view('message-sent');
    } catch(Exception $e) {
            // return view('welcome', ['exception' => $e->getMessage()]);
            return response('An exception occured: ' . $e->getMessage(), 500);
    }
    }

    public function send(Request $req) {
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TKN');
            $twilio = new Client($sid, $token);

            foreach ($this->sandbox_numbers as $contact) {
                $message = $twilio->messages->create(
                    'whatsapp:' . $contact,
                    [
                        'from' => 'whatsapp:+14155238886',
                        'body' => $req->input('body')
                    ]
                );

                // Send out the message. 
                $message->sid;
            }
            return back();
        } catch (\Exception $e) {
            return response('An exception occured while sending message: ' . $e->getMessage(), 500);
        }
    }
}