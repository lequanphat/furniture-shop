<!DOCTYPE html>
<html lang="en">
    @include('components.head')
    <body>
        @if(!session('user'))
            <script>window.location = "/login";</script>
        @endif
        <div class="flex items-center justify-center w-[100vw] h-[100vh]">
            @include('components.navbar')
            <div class="p-4 flex-1 h-[100%]">
                @yield('content')
            </div>
        </div>
    </body>
</html>