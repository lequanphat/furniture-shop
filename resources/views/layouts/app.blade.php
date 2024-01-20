<!DOCTYPE html>
<html lang="en">
    @include('components.head')
    <body>
        @if(!session('user'))
            <script>window.location = "/login";</script>
        @endif
        @include('components.header')
        @yield('content')
        @include('components.footer')
    </body>
</html>