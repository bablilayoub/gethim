<?php

namespace App\Http\Controllers;

use App\Models\Links;
use App\Models\Clicks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use hisorange\BrowserDetect\Facade as Browser;

class LinksController extends Controller
{
    public function index()
    {
        // Get the user's links
        $links = Links::where("user_token", auth()->user()->token)->orderBy("id", "desc")->paginate(7);

        // Return the links
        return view("links", [
            "links" => $links,
        ]);
    }

    public function shorten()
    {
        // Validate the URL
        $validator = Validator::make(request()->all(), [
            "url" => "required|url",
        ]);

        // If the URL is invalid, return an error
        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Invalid URL (make sure to include http/https)",
            ]);
        }

        // Create a new link
        $link = Links::create([
            "user_token" => auth()->user()->token,
            "original_url" => request("url"),
            "token" => $this->generate_random_token(6),
        ]);

        // if failed to create a new link, return an error
        if (!$link) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to create a new link",
            ]);
        }

        // Return the shortened URL
        return response()->json([
            "status" => "success",
            "message" => "Link shortened successfully",
            "shortened_url" => route("visit", ["token" => $link->token]),
        ]);
    }

    public function visit($token)
    {
        // if bot, redirect to home
        if (Browser::isBot()) {
            return redirect()->route("home")->with("error", "Bot detected");
        }

        // Find the link
        $link = Links::where("token", $token)->first();

        // If the link doesn't exist, return an error
        if (!$link) {
            return redirect()->route("home")->with("error", "Link not found");
        }

        // Get the visitor information
        $visitor_info = geoip()->getLocation(request()->ip());

        // If the visitor information is not available, set default values
        if ($visitor_info->default) {
            $visitor_info = [
                "country" => "Unknown",
                "city" => "Unknown",
                "state_name" => "Unknown",
                "lat" => "0",
                "lon" => "0",
            ];
        }

        // Create a new visit
        $click = Clicks::create([
            "link_token" => $link->token,
            "user_token" => $link->user_token,
            "user_agent" => Browser::platformFamily() . ", " . Browser::browserFamily() . ", " . Browser::deviceFamily(),
            "ip_address" => request()->ip(),
            "referer" => request()->header("Referer"),
            "country" => $visitor_info["country"],
            "city" => $visitor_info["city"],
            "region" => $visitor_info["state_name"],
            "latitude" => $visitor_info["lat"],
            "longitude" => $visitor_info["lon"],
        ]);

        if (!$click) {
            return redirect()->route("home")->with("error", "Failed to create a new visit");
        }

        // increment the link clicks
        $link->increment("clicks");

        // Redirect to the original URL
        return redirect($link->original_url);
    }

    // Delete a link
    public function delete()
    {
        // Validate the token
        $validator = Validator::make(request()->all(), [
            "token" => "required|exists:links,token",
        ]);

        // If the token is invalid, return an error
        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Invalid token",
                "errors" => $validator->errors(),
            ]);
        }

        // Find the link where the token matches and the user token matches
        $link = Links::where("token", request("token"))
            ->where("user_token", auth()->user()->token)
            ->first();

        // If the link doesn't exist, return an error
        if (!$link) {
            return response()->json([
                "status" => "error",
                "message" => "Link not found",
            ]);
        }

        // Delete the link
        $link->delete();

        // Return a success response
        return response()->json([
            "status" => "success",
            "message" => "Link deleted successfully",
        ]);
    }

    // Get the link stats
    public function stats()
    {
        // Validate the token
        $validator = Validator::make(request()->all(), [
            "token" => "required|exists:links,token",
        ]);

        // If the token is invalid, return an error
        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Invalid token",
                "errors" => $validator->errors(),
            ], 422);
        }

        // Find the link where the token matches and the user token matches
        $link = Links::where("token", request("token"))
            ->where("user_token", auth()->user()->token)
            ->first();

        // If the link doesn't exist, return an error
        if (!$link) {
            return response()->json([
                "status" => "error",
                "message" => "Link not found",
            ]);
        }

        // Get the link stats
        $clicks = Clicks::where("link_token", $link->token)->orderBy("id", "desc")->get();

        // Return the stats
        return response()->json([
            "status" => "success",
            "message" => "Link stats",
            "stats" => $clicks,
        ]);
    }

    private function generate_random_token($length)
    {
        // Generate a random token
        $token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", $length)), 0, $length);

        // Check if the token already exists
        if (Links::where('token', $token)->exists()) {
            // Generate a new token (recursion)
            return $this->generate_random_token($length);
        }

        // Return the token
        return $token;
    }
}
