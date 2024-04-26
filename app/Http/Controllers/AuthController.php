<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    public function login_view()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        // validate data
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($request->only('email','password'))){
            return redirect('home');
        }

        return redirect('login')->withError('Login details are not valid');

    }

    public function register_view()
    {
        return view('auth.register');
    }


    public function register(Request $request){
        // validate 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:candidate,employer',
        ]);

         // save in users table 
    try {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => $request['role'],
        ]);

        // Redirect to the login page with success message
        return redirect('login')->withSuccess('Registration successful. You can now login.');
    } catch (\Exception $e) {
        // Redirect back to register page with error message
        return redirect('register')->withError('Error registering user. Please try again.');
      
    }
    }


    public function home(){
        return view('home');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('');
    }

}