<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    //
    public function register (Request $request) {
        // Validate and store the user data
            $data = $request->validate([
                'name' => 'required|min:3|max:50',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
            ]);

            // Hash the password
            $data['password'] = Hash::make($data['password']);

            // Create and save the user
            $user = User::create($data);
            // Send verification
            // $user->sendEmailVerificationNotification();
            return redirect()->route('home');
    }

    public function login(Request $request) {
        if (auth()->check()) {
            // Redirect the user to the dashboard if he is already logged in
            return redirect()->route('home');
        }

        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (auth()->attempt($validatedData, $request->has('remember'))) {
            // Authentication passed...
            return redirect()->route('home');
        } else {
            // Authentication failed...
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('home');
    }

}
