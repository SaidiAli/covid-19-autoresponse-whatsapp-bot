<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $req) {
        $req->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
    }
}
