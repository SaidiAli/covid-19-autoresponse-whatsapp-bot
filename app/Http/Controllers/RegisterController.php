<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class RegisterController extends Controller
{
    public function index() {
        return view('register');
    }

    public function register(Request $request) {
        $this->validator($request);

        Cookie::queue($this->getName($request), $request->input('password'));

        $user = User::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect('/');
    }

    public function validator($request) {
       return $request->validate([
            'name' => 'required|string|unique:users',
            'password' => 'required|string'
        ]);
    }

    public function getName($request) {
        return 'user_'.$request->input('name');
    }

    public function getAuthName($request) {
        return $request->input('name');
    }
}
