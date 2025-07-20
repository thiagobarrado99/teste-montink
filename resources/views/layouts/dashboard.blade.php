<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')
<body class="antialiased">
    @include('layouts.nav')
    @include('layouts.sidebar')
    <div id="app" class="main-content">
        <div class="card">
            <div class="card-header">@yield('header')</div>
            <div class="card-body">@yield('content')</div>                    
            <div class="card-footer">@yield('footer')</div>
        </div>
        @include('sweetalert::alert')
    </div>
    @include('layouts.footer')
</body>
</html>
