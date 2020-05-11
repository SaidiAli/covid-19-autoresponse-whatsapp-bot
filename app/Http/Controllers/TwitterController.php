<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwitterController extends Controller
{
    public function crc(Request $req) {
        // Challenge-Response Checks
        $crc_token = $req->query('crc_token');
        $sha256_hash = hash_hmac('sha256', $crc_token, env('TWITTER_SECRET_KEY'));
        $res = 'sha256=' . base64_encode($sha256_hash);

        return response()->json(['response_token' => $res]);
    }
}
