<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $user;

    public function index()
    {
        return view('login');
    }

    public function login(Request $request) {
        $this->validator($request);

        if($this->checkCredentials($request)) {
            Cookie::queue('user_' . $this->getName($request), $request->input('password'));

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
        $user = $this->retrieveByCredentials($request);

        if(is_null($user)) {
            return;
        }

        if($request->input('name') == $user->name) {
            return $user;
        }

        return false;
    }

    public function retrieveByCredentials($request) {
        $user = User::firstWhere('name' , $this->getName($request));

        $this->user = $user;

        return $user;
    }

    public function getName($request) {
        return $request->input('name');
    }

    public function logout(Request $request) {
        // 
    }
}
