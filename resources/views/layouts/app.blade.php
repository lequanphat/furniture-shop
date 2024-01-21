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
        <div class="w-[80%] mx-auto">
            @yield('content')
        </div>
        @include('components.footer')
    </body>
</html>