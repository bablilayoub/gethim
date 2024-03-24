<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    // Login the user
    public function login()
    {
        // if token is already in cookie or session
        if (cookie('token') || session('token')) {
            // Get the user by token
            $user = User::where('token', cookie('token'))->first();

            // Check if the user is not found , then check in session
            if (!$user) {
                $user = User::where('token', session('token'))->first();
            }

            // Check if the user exists
            if ($user) {
                // Save the token in the session
                session(['token' => $user->token]);

                // Authenticate the user
                auth()->login($user);

                // Return
                return;
            }
        }

        // Generate a random token
        $token = $this->generate_random_token(20);

        // Create a new user
        $user = new User();

        $user->token = $token;
        $user->role = 'user';

        $user->save();

        // Save the token in the session & cookie
        session(['token' => $token]);

        // Set the token in the cookie for unlimited time
        cookie('token', $token);

        // Authenticate the user
        auth()->login($user);
    }

    // Generate a random token
    private function generate_random_token($length)
    {
        // Generate a random token
        $token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", $length)), 0, $length);

        // Check if the token already exists
        if (User::where('token', $token)->exists()) {
            // Generate a new token (recursion)
            return $this->generate_random_token($length);
        }

        // Return the token
        return $token;
    }

    // Index
    public function index()
    {
        // Check if the user is not logged in
        if (!auth()->check()) {
            // Login the user
            $this->login();
        }

        // Return the view
        return view('main');
    }
}
