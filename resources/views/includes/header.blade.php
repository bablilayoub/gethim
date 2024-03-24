<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ config('app.name', 'NiceHalf') }} - The URL Shortener & Tracker">
    <meta name="author" content="NiceHalf">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="url, shortener, get him, nicehalf, free, track, clicks, prank, friends">
    <title>{{ config('app.name', 'NiceHalf') }} - @yield('title')</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
