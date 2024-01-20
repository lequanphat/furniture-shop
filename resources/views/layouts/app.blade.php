<!DOCTYPE html>
<html lang="en">
    @include('components.head')
    <body>
        @if (session('user') && is_object(session('user')))
            @if(!in_array("user", session('user')->getRoleNames()->toArray()))
                <script>window.location = "/admin";</script>
            @endif
        @else
            <script>window.location = "/login";</script>
        @endif
        @include('components.header')
        @yield('content')
        @include('components.footer')
    </body>
</html>