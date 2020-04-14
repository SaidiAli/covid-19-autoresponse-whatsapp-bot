<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\MessagingResponse;
use Illuminate\Support\Facades\Http;
class InBoundMessageController extends Controller
{
    // Globals
    protected $greetings = ['hello', 'hi'];

    protected $rdc_link = "<Response><Message>Here is a direct link to all the contacts of the RDC's of Uganda. Reach out to get any assistance. <![CDATA[http://www.nrmnationalchairman.com/all-rdcs-contact-list/]]></Message></Response>";

    protected $key_words = [
        "symptoms" => "Theses are some of the symptoms for the covid-19 disease: \n - Fever\n - Fatigue\n - Dry and consistent Cough\n - Difficulty in breathing \n - Runny or stuffy nose.\n - Muscle aches, body aches or headaches. \n if you\'re experiencing any of these, please see a medical personel or call on the ministry of Health toll free lines to get aid: \n 0800203033 or 919",

        "prevent" => "These are some of the ways you can prevent yourself from the deadly coronavirus:\n - The incubation period for the novel coronavirus is between 2 - 14 days. Understanding the incubation period is very important for health authorities as it allows them to introduce more effective quarantine systems for people suspected of carrying the virus.\n - Also wash your hands regularly and frequently with soap or alcohol based solution for a period not less than 20 seconds. This will the virus if contracted wothout you knowing. \n - Prevent yourself from touching the soft parts of your body including the mouth, nose and eyes. This can be effected by wearing a certified face mask.\n Keep a social distance from people and crowds. This is very important.",

        "prevention" => "These are some of the ways you can prevent yourself from the deadly coronavirus:\n - The incubation period for the novel coronavirus is between 2 - 14 days. Understanding the incubation period is very important for health authorities as it allows them to introduce more effective quarantine systems for people suspected of carrying the virus.\n - Also wash your hands regularly and frequently with soap or alcohol based solution for a period not less than 20 seconds. This will the virus if contracted wothout you knowing. \n - Prevent yourself from touching the soft parts of your body including the mouth, nose and eyes. This can be effected by wearing a certified face mask.\n Keep a social distance from people and crowds. This is very important.",

        "preventive" => "These are some of the ways you can prevent yourself from the deadly coronavirus:\n - The incubation period for the novel coronavirus is between 2 - 14 days. Understanding the incubation period is very important for health authorities as it allows them to introduce more effective quarantine systems for people suspected of carrying the virus.\n - Also wash your hands regularly and frequently with soap or alcohol based solution for a period not less than 20 seconds. This will the virus if contracted wothout you knowing. \n - Prevent yourself from touching the soft parts of your body including the mouth, nose and eyes. This can be effected by wearing a certified face mask.\n Keep a social distance from people and crowds. This is very important.",

        'helplines' => "These are the Covid-19 official toll free helplines: \n 0800203033 or 919",

        "help" => "This is the covid-19 auto-response bot that provides accurate information as given by the government of Uganda. I use keywords to find an appropriate answer to your question. Try questions containing any of these keywords: \n - helplines \n - symptoms \n - prevent, prevention, preventive.\n - update or updates \n\n That is what I can provide for now. \n You also get updates on the current situation and also receive tweets direct from the account of the Ministry of Health of the Republic of Uganda. \n Stay safe, Stay home. \n *Made by Bonstana*"
        ];

    public function index(Request $req) {

        try {
            $response = new MessagingResponse();

            $corona_data_all = Http::get('https://corona.lmao.ninja/all')->json();
            $corona_data_ug = Http::get('https://corona.lmao.ninja/countries/uganda')->json();

            $covid_summary = "Here is the summary for the covid-19 situation as of today (Global): \n" . "New Confirmed: " . $corona_data_all['todayCases'] . "\n Total Confirmed: " . $corona_data_all['cases'] . "\n New Deaths: " . $corona_data_all['todayDeaths'] . "\n Total Deaths: " . $corona_data_all['deaths'] . " \u{1F622}\n Recovered: " . $corona_data_all['recovered'] . " \n Active: " . $corona_data_all['active'] . "\n Critical: " . $corona_data_all['critical'] . "\n\n" . "Uganda Summary: \n New Confirmed: " . $corona_data_ug['todayCases'] . "\n Total Confirmed: " . $corona_data_ug['cases'] . "\n New Deaths: " . $corona_data_ug['todayDeaths'] . "\n Total Deaths: " . $corona_data_ug['deaths'] . "\n Total Recovered: " . $corona_data_ug['recovered'] . "\n\n _data by:_\n thevirustracker.com \n worldometers.info \u{1F30F}\n\n brought to you by yours truly: *Bonstana* \u{1F60E}";

            $body = $req->Body;
            $message_arr = explode(' ', trim($body));


            // Check for greeting from user
            if(count($message_arr) == 1) {
                foreach ($message_arr as $value) {
                    if(\in_array(strtolower($value), $this->greetings)) {
                        $response->message("Hello there, this is the covid-19 auto-response bot that provides accurate information as given by the government of Uganda. \n It also has cool features like forwarding tweets from the ministry of health twitter account. Please feel free to ask any questions to get instant answers. \n These are the covid-19 toll free lines: \n 0800203033 \n Stay Home, Stay safe. \n - *Made by Bonstana*");
                    }
                }
            }

            // Check for key words and give answers.
            foreach ($this->key_words as $key => $value) {
                foreach ($message_arr as $message) {
                    if (strtolower($message) == $key){
                        $response->message($value);
                    }else if(strtolower($message) == 'rdc') {
                        return response($this->rdc_link, 200, ['Content-Type' => 'text/xml']);
                    }else {
                        continue;
                    }
                }
            }

            foreach ($message_arr as $value) {
                if (strtolower($value) == 'updates' or strtolower($value) == 'update') {
                    $response->message($covid_summary);
            }
        }
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
