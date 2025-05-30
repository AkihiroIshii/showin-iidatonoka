@props(['informations' => []])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            {{-- <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div> --}}

            <!-- お知らせセクション -->
            @if($informations->isNotEmpty())
                <div class="mb-4 text-center bg-yellow-100 text-yellow-800 px-4 py-2 rounded">
                    <strong>お知らせ</strong>
                    @foreach($informations as $information)
                        <div class="mt-2 mb-2">
                            <ul class="ml-4 text-left list-disc">
                                <li>{{ $information->content }}</li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- 書く蔵セクション -->
            @if(\Carbon\Carbon::now()->day <= 15)
                <div class="mb-4 text-center bg-blue-100 text-blue-800 px-4 py-2 rounded">
                    <p>月例作文「書く蔵」申込受付中（毎月1日～15日）</p>
                </div>
            @endif

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
