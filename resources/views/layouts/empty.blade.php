<!DOCTYPE html>
<html lang="en">
    @include('components.head')
    <body>
        @if(session('user'))
        <script>window.location = "/";</script>
         @endif
        @yield('content')
    </body>
</html>