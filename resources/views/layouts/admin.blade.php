<!DOCTYPE html>
<html lang="en">
    @include('components.head')
    <body class="dark">
        @if (session('user') && is_object(session('user')))
            @if(!in_array("admin", session('user')->getRoleNames()->toArray()))
                <script>window.location = "/";</script>
            @endif
        @else
            <script>window.location = "/login";</script>
        @endif

        <div class="flex items-center justify-center w-[100vw] h-[100vh]">
            @include('admin.components.navbar')
            <div class="flex-1 h-[100%]">
                @include('admin.components.header')
                <div class="p-4">@yield('content')</div>
            </div>
        </div>
    </body>
</html>