<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\MessagingResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Twilio\Rest\Client;
class InBoundMessageController extends Controller
{
    // Globals
    protected $greetings = ['hello', 'hi'];

    protected $rdc_link = "<Response><Message>Here is a direct link to all the contacts of the RDC's of Uganda. Reach out to get any assistance. <![CDATA[http://www.nrmnationalchairman.com/all-rdcs-contact-list/]]></Message></Response>";

    protected $key_words = [
        "symptoms" => "Theses are some of the symptoms for the covid-19 disease: \n\n - Fever\n - Fatigue\n - Dry and consistent Cough\n - Difficulty in breathing \n - Runny or stuffy nose.\n - Muscle aches, body aches or headaches. \n\n if you're experiencing any of these, please see a medical personel or call on the Ministry of Health toll free lines to get aid \xF0\x9F\x93\x9E: \n 0800203033 or 919",

        "prevent" => "These are some of the ways you can prevent yourself from the deadly coronavirus:\n\n - The incubation period for the novel coronavirus is between 2 - 14 days. Understanding the incubation period is very important for health authorities as it allows them to introduce more effective quarantine systems for people suspected of carrying the virus.\n - Also wash your hands regularly and frequently with soap or alcohol based solution for a period not less than 20 seconds. This will the virus if contracted wothout you knowing. \n - Prevent yourself from touching the soft parts of your body including the mouth, nose and eyes. This can be effected by wearing a certified face mask.\n Keep a social distance from people and crowds. This is very important.",

        "prevention" => "These are some of the ways you can prevent yourself from the deadly coronavirus:\n\n - The incubation period for the novel coronavirus is between 2 - 14 days. Understanding the incubation period is very important for health authorities as it allows them to introduce more effective quarantine systems for people suspected of carrying the virus.\n - Also wash your hands regularly and frequently with soap or alcohol based solution for a period not less than 20 seconds. This will the virus if contracted wothout you knowing. \n - Prevent yourself from touching the soft parts of your body including the mouth, nose and eyes. This can be effected by wearing a certified face mask.\n Keep a social distance from people and crowds. This is very important.",

        "preventive" => "These are some of the ways you can prevent yourself from the deadly coronavirus:\n\n - The incubation period for the novel coronavirus is between 2 - 14 days. Understanding the incubation period is very important for health authorities as it allows them to introduce more effective quarantine systems for people suspected of carrying the virus.\n - Also wash your hands regularly and frequently with soap or alcohol based solution for a period not less than 20 seconds. This will the virus if contracted wothout you knowing. \n - Prevent yourself from touching the soft parts of your body including the mouth, nose and eyes. This can be effected by wearing a certified face mask.\n Keep a social distance from people and crowds. This is very important.",

        'helplines' => "These are the Covid-19 official toll free helplines \xF0\x9F\x93\x9E: \n 0800203033 or 919",
        ];

        protected $all_keywords = [
            'update', 'updates', 'symptoms', 'prevent', 'preventive', 'prevention', 'helplines', 'rdc', 'rdcs'
        ];

    public function index(Request $req) {

        try {
            $response = new MessagingResponse();

            // Message body
            $body = $req->Body;
            $message_arr = explode(' ', trim($body));


            // Check for greeting from user
            if(count($message_arr) == 1) {
                foreach ($message_arr as $value) {
                    if(\in_array(strtolower($value), $this->greetings)) {
                        $response->message("*Welcome to the WhatsAppCovidBot*\n\nThis is the covid-19 auto-response bot that provides accurate information from trusted sources. \nI use *keywords* to find an appropriate answer to your question. Phrase a question with any of these keywords to get a response or just send the word: \n\n \xF0\x9F\x91\x89 *helplines* - to get the covid-19 toll free lines \xF0\x9F\x93\x9E \n \xF0\x9F\x91\x89 *symptoms* - to get infor on the symptoms of the disease and how to protest yourself \n \xF0\x9F\x91\x89 *prevent, prevention, preventive* - you probably guessed what that does already \n \xF0\x9F\x91\x89 *update or updates* - to get realtime updates on the numbers on covid-19 cases global and Uganda \n \xF0\x9F\x91\x89 *news* - to get a news article from top sources anytime \n \xF0\x9F\x91\x89 *hi or help* - get this  message again.\n \xF0\x9F\x91\x89 *rdc* - to get the contact list of all RDCs in Uganda \n\n You also get news on the current situation around the world. \n\n *Stay Home, Stay Safe* \n\n *Made by Bonstana* \xF0\x9F\x98\x8E");
                    }
                }
            }

            // Check for key words and give answers.
            foreach ($this->key_words as $key => $value) {
                foreach ($message_arr as $message) {
                    if (strtolower($message) == $key){
                        $response->message($value);
                    }else if(strtolower($message) == 'rdc' or strtolower($message) == 'rdcs') {
                        return response($this->rdc_link, 200, ['Content-Type' => 'text/xml']);
                    }else {
                        continue;
                    }
                }
            }

            foreach ($message_arr as $value) {
                if (strtolower($value) == 'updates' or strtolower($value) == 'update') {
                    $corona_data_all = Http::get('https://corona.lmao.ninja/v2/all')->json();
                    $corona_data_ug = Http::get('https://corona.lmao.ninja/v2/countries/uganda')->json();

                    if ($corona_data_all['updated']) {
                        $covid_summary = "Here is the summary for the covid-19 situation as of today (Global): \n\n" . "New Confirmed: " . $corona_data_all['todayCases'] . "\n Total Confirmed: " . $corona_data_all['cases'] . "\n New Deaths: " . $corona_data_all['todayDeaths'] . "\n Total Deaths: " . $corona_data_all['deaths'] . " \u{1F622}\n Recovered: " . $corona_data_all['recovered'] . "\xF0\x9F\x92\xAA" . " \n Active: " . $corona_data_all['active'] . "\n Critical: " . $corona_data_all['critical'] . "\n\n" . "*Uganda Summary:* \n New Confirmed: " . $corona_data_ug['todayCases'] . "\n Total Confirmed: " . $corona_data_ug['cases'] . "\n New Deaths: " . $corona_data_ug['todayDeaths'] . "\n Total Deaths: " . $corona_data_ug['deaths'] . "\n Total Recovered: " . $corona_data_ug['recovered'] . "\xF0\x9F\x92\xAA" . "\n\n \xE2\x80\xBC Send ```update``` to get this message again \n \xE2\x80\xBC Send ```hi or hello``` to get a helper menu \n\n _data by:_\n thevirustracker.com \n worldometers.info \u{1F30F}\n\n brought to you by yours truly: *Bonstana* \xF0\x9F\x98\x8E";

                        $response->message($covid_summary);
                    } else {
                        $response->message("Ooops, the server is a down temporarily, come back in a few and check again . \n\n Meanwhile you can checkout the other cool features \xF0\x9F\x98\x89 \n\n Send ```hi or hello``` to get a helper menu");

                        $sid = env('TWILIO_SID');
                        $token = env('TWILIO_TKN');
                        $twilio = new Client($sid, $token);

                        // send feedback
                        $twilio->messages->create(
                            'whatsapp:+256753672882',
                            [
                                'from' => 'whatsapp:+14155238886',
                                'body' => "The corona api just crushed, check it out .... !! Status is not ok"
                            ]
                        )->sid;
                    }
            }
        }

            foreach ($message_arr as $value) {
                if(strtolower($value) == 'news') {
                    $us_news = Http::get('https://newsapi.org/v2/top-headlines?country=us&apiKey=' . env('NEWS_API_KEY') . '&q=coronavirus&category=health')->json();

                    if($us_news['status'] == 'ok') {
                        // fetch a random article
                        $article = collect($us_news['articles'])->random();

                        $msg = "*NEWS HOURS*: \n\n *Headline:* \xF0\x9F\x91\x89" . $article['title'] . "\n\n" . $article['description'] . "\n\n Link: " . $article['url'] . "\n\n ``` Social Distancing is an opportunity to check if you can tolerate your own company` - just a quote`` \n\n \xE2\x80\xBC Send ```hi or hello``` to get a helper menu\n *Stay Home, Stay Safe*";

                        $response->message($msg);
                    } else {
                        $response->message("Ooops, the server is a down temporarily, come back in a few and check again . \n\n Meanwhile you can checkout the other cool features \xF0\x9F\x98\x89 \n\n Send ```hi or hello``` to get a helper menu");

                        $sid = env('TWILIO_SID');
                        $token = env('TWILIO_TKN');
                        $twilio = new Client($sid, $token);

                        // send feedback
                        $twilio->messages->create(
                            'whatsapp:+256753672882',
                            [
                                'from' => 'whatsapp:+14155238886',
                                'body' => "The newsApi just crushed, check it out .... !! Status is not ok"
                            ]
                        )->sid;
                    }
                }
            }

        // Process sending message from whatsapp..
            if($body == 'su') {
                Http::get('https://frozen-basin-63569.herokuapp.com/updates');
            } else if($body == 'sn') {
                Http::get('https://frozen-basin-63569.herokuapp.com/news');
            }



        // $message_array = collect($message_arr)->map(function ($item) {
        //     return strtolower($item);
        // })->all();

        // if(!(Arr::has($message_array, $this->all_keywords))) {
        //     $response->message("Sorry I could not catch your question quite right.!! \xE2\x9A\xA0 \n Please send  ```'help'```  to get instructions on how i can help. \n *Thank you*");
        // }


            Log::info('Sender Info: ', [
                'from:' => $req->From,
                'To: ' => $req->To,
                'Body: ' => $req->Body
            ]);

            return response($response, 200, ['Content-Type' => 'text/xml']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
