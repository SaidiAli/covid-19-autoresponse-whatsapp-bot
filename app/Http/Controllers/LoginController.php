<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $user = [];

    public function __construct()
    {
        array_push($this->user, env('USER_NAME'), env('PASSWORD'));
    }

    public function index()
    {
        return view('login');
    }

    public function login(Request $request) {
        $this->validator($request);

        if($this->checkCredentials($request)) {
            Cookie::queue('user_' . $this->user[0], $this->user[1]);

            return redirect('/');
        }

        return redirect('/login');
    }

    public function validator($request) {
        return $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
        ]);
    }

    public function checkCredentials($request) {
        if(is_null($this->user)) {
            return;
        }

        if($request->input('name') == $this->user[0] and $request->input('password') == $this->user[1]) {
            return $this->user;
        }

        return false;
    }

    public function getName($request) {
        return $request->input('name');
    }

    public function logout(Request $request) {
        // Remove user cookie
        setcookie('user_saidiali', '', 0 , '/');

        return redirect('/login');
    }
}
