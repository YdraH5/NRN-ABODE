<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>    
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        
    </head>
    <body class="bg-smokewhite">
       
           
        @include('components.layouts.navigation')
        <!-- Page Heading -->
 
        @if (isset($header))
            <header class="bg-white shadow w-full">
                <div class="max-w-full mx-8 py-2 px-12 ">
                    {{ $header }}
                </div>
            </header>
        @endif
        <!-- Page Content -->
            @yield('content')
            @livewireScripts
    </body>
</html>

