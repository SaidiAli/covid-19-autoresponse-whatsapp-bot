<?php
$str1 = "hello";
$str2 = "wakiso Rdc Prevent";
$arr = explode(' ', $str2);
$test = [
    'rdc' => 'http://rdc_list_link.com',
    'symptoms' => "Theses are some of the symptoms for the covid-19 disease: \n --- \n if you're experiencing any of these, please see a medical personel or call on the ministry of Health toll free lines to get aid: 0800203033",
    'prevent' => "These are some of the ways you can prevent yourself from the deadly coronavirus:",
    'helplines' => "These are the Covid-19 official toll free helplines: \n 0800203033"
];

foreach ($test as $key => $msg) {
    foreach($arr as $val) {
        if (strtolower($val) == $key) {
            print_r($msg."\n");
        }else {
            continue;
        }
    }
}


// $new = chunk_split($string, 5);
// print_r(str_split(trim($string)));

// print_r(count(explode(' ', trim($string))));
// print_r(implode('-', explode(' ', trim($string))));
