<?php

namespace App\Http\Controllers;

use App\Models\Clicks;
use App\Models\User;
use App\Models\Links;
use Illuminate\Http\Request;

class AuthController extends Controller
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

        // Redirect the user
        return redirect()->route('home');
    }

    // Logout the user
    public function logout()
    {
        // Get the user id
        $user_id = auth()->id();

        // Remove the token from the session & cookie
        session()->forget('token');
        cookie()->forget('token');

        // Get the user
        $user = User::find($user_id);

        // Delete the links
        Links::where('user_token', $user->token)->delete();
        Clicks::where('user_token', $user->token)->delete();

        // Delete the user
        User::destroy($user_id);

        // Logout the user
        auth()->logout();

        // Generate a new token
        $token = $this->generate_random_token(20);

        // Create a new user
        $user = new User();
        $user->token = $token;
        $user->role = 'user';
        $user->save();

        session(['token'=> $token]);
        cookie('token', $token);

        auth()->login($user);

        // Redirect the user
        return redirect()->route('home')->with('success', 'Your data has been reset successfully');
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
}
