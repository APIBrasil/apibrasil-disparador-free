<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
        
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Disparador open source de mensagens via WhatsApp">
    <meta name="author" content="APIBrasil">
    <link rel="shortcut icon" href="favicon.ico"> 

    <!-- meta csrf -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="bearer_token_api_brasil" content="{{ Auth::user()->bearer_token_api_brasil ?? ''}}">
    <meta name="profile_id" content="{{ Auth::user()->profile_id ?? ''}}">
    
    <!-- FontAwesome JS-->
    <script defer src="{{ asset('/assets/plugins/fontawesome/js/all.min.js') }}" ></script>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />

    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">

    <style>
        th{
            text-align: center !important;
        }
    </style>
    
</head>
<body class="app">
    <div class="top">
        @include('layouts.partials.top')
    </div>

    @include('layouts.partials.header')

    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
            @yield('content')
        </div>
                                        
    </div>

    <div class="footer">
        @include('layouts.partials.footer')
    </div>

    @yield('scripts')
    
</body>
</html>
