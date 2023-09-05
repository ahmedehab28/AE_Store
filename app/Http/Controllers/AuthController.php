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
    public function register(Request $request) {
        try {
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
            // // Send email verification -- Not implemented yet
            // $user->sendEmailVerificationNotification();
            return redirect()->route('home');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withErrors(['An error occurred while processing your request. Please try again later.']);
        } catch (\Throwable $th) {
            return back()->withErrors(['An unexpected error occurred. Please try again later.']);
        }
    }


    public function login(Request $request) {
        if (auth()->check()) {
            // Redirect the user to the dashboard if he is already logged in
            return redirect()->route('home');
        }

        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);

            if (auth()->attempt($validatedData, $request->has('remember'))) {
                return redirect()->route('home');
            } else {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // the errors coming from data validation up there
            return back()->withErrors($e->validator->errors());
        } catch (\Illuminate\Database\QueryException $e) {
            // database errors, incase not connected or error in query
            return back()->withErrors(['An error occurred while processing your request. Please try again later.']);
        } catch (\Throwable $th) {
            // any other exceptions will be handled here
            return back()->withErrors(['An unexpected error occurred. Please try again later.']);
        }
    }


    public function logout() {
        Auth::logout();
        return redirect()->route('home');
    }

}
