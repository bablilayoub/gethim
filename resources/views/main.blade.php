@section('title', 'The URL Shortener & Tracker')

@extends('layouts.app')

@section('content')
    <div class="fixed bottom-4 right-4 z-[1]">
        <div class="dropdown dropdown-top dropdown-end">
            <div tabindex="0" role="button" class="m-1 btn btn-square btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dots-vertical" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="12" r="1"></circle>
                    <circle cx="12" cy="19" r="1"></circle>
                    <circle cx="12" cy="5" r="1"></circle>
                </svg>
            </div>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="{{ route('links') }}">Manage Links</a></li>
                <li><a onclick="themes_modal.showModal()">Change Theme</a></li>
                <li><a onclick="reset_data_modal.showModal()">Reset Data</a></li>
            </ul>
        </div>
    </div>
    <div class="hero bg-base-200 h-screen">
        <div class="hero-content text-center">
            <div class="max-w-lg">
                <!-- Site name and description -->
                <a class="text-4xl font-bold text-primary" href="{{ route('home') }}">
                    Get Him ! - The URL Shortener
                </a>
                <p class="py-6">You got scammed ? or maybe you want to prank your friends ? Get Him ! is the perfect tool
                    for you. Shorten your URL and track the clicks !, all for free !</p>
                <!-- Shorten URL -->
                <div class="join w-full" id="shorten_url">
                    <input type="url" id="url" placeholder="Enter your URL"
                        class="w-full input input-primary input-bordered join-item" required="">
                    <button type="button" class="btn btn-primary join-item" id="shorten">Shorten</button>
                </div>
                <!-- Error and success messages -->
                <div class="flex justify-center">
                    <div role="alert" class="alert alert-error mt-4 hidden" id="error_container">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="error_message"></span>
                    </div>
                    <div role="alert" class="alert alert-success mt-4 hidden" id="success_container">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="success_message"></span>
                    </div>
                </div>
                <!-- Short another URL -->
                <div class="text-center mt-6 hidden" id="short_another">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-info">Short another URL</a>
                </div>
                <div class="text-center mt-6">
                    <!-- Made by -->
                    <a href="https://github.com/bablilayoub" class="btn btn-sm btn-primary" target="_blank">By Ayoub
                        Bablil</a>
                    <!-- Copyright -->
                    <div class="text-center mt-6">
                        <p class="text-xs text-center text-gray-500">
                            © 2024 <a class="text-primary" href="{{ route('home') }}">Get Him !</a> - All rights reserved.
                        </p>
                        <p class="text-xs text-center text-gray-500 mt-2">
                            Please be informed that our system securely stores the public IP addresses of individuals who
                            access our shortened links. This data is strictly used for analytical purposes and does not
                            provide exact geographical locations. We prioritize user privacy and adhere to stringent data
                            protection measures.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
