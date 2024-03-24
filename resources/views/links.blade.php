@section('title', 'Manage your links')

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
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a onclick="themes_modal.showModal()">Change Theme</a></li>
                <li><a onclick="reset_data_modal.showModal()">Reset Data</a></li>
            </ul>
        </div>
    </div>
    <div class="hero bg-base-200 h-screen">
        <div class="hero-content text-center max-w-2xl">
            <div class="max-w-md mx-auto md:max-w-xl lg:max-w-4xl">
                <!-- Site name and description -->
                <a class="text-4xl font-bold text-primary" href="{{ route('home') }}">
                    Get Him ! - The URL Shortener
                </a>
                <p class="py-6">Here are your shortened links and their statistics.</p>
                <!-- Links table -->
                @if ($links->isEmpty())
                    <div class="alert alert-warning">
                        You have not shortened any URLs yet.
                    </div>
                    <div class="text-center mt-6">
                        <a href="{{ route('home') }}" class="btn btn-sm btn-info">Shorten a URL</a>
                    </div>
                @else
                    <div class="overflow-x-auto w-full">
                        <table class="table table-zebra bg-base-100 text-base-content">
                            <thead>
                                <tr>
                                    <th>Original URL</th>
                                    <th>Shortened URL</th>
                                    <th>Clicks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="links_table">
                                @foreach ($links as $link)
                                    <tr id="link_{{ $link->token }}">
                                        <td class="truncate">
                                            <a href="{{ $link->original_url }}" target="_blank">
                                                {{ substr($link->original_url, 0, 40) }}...</a>
                                        </td>
                                        <td class="truncate">
                                            <a href="{{ $link->shortened_url }}"
                                                target="_blank">{{ substr($link->shortened_url, 0, 40) }}...</a>
                                        </td>
                                        <td>{{ number_format($link->clicks) }}</td>
                                        <td class="flex space-x-1">
                                            <button class="btn btn-sm btn-square btn-primary"
                                                onclick="viewStats('{{ $link->token }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-chart-bar">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M3 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                    <path
                                                        d="M9 8m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                    <path
                                                        d="M15 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                    <path d="M4 20l14 0" />
                                                </svg>
                                            </button>
                                            <button class="btn btn-sm btn-square btn-warning"
                                                onclick="copyToClipboard('{{ $link->shortened_url }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                    <path
                                                        d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                                </svg>
                                            </button>
                                            <button class="btn btn-sm btn-square btn-error"
                                                onclick="deleteLink('{{ $link->token }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="pagination mt-6 w-full">
                        {{ $links->links() }}
                    </div>
                @endif
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
