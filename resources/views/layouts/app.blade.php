<!DOCTYPE html>
<html lang="en">
    @include('components.head')
    <body>
        @include('components.header')
        @yield('content')
        @include('components.footer')
    </body>
</html>