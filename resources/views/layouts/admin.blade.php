<!DOCTYPE html>
<html lang="en">
@include('components.head')

<body class="dark">
    @if (session('user') && is_object(session('user')))
        @if (session('user')->type != 'admin')
            <script>
                window.location = "/";
            </script>
        @endif
    @else
        <script>
            window.location = "/login";
        </script>
    @endif

    <div class="flex h-[100vh] w-[100vw] items-center justify-center">
        @include('admin.components.navbar')
        <div class="h-[100%] flex-1">
            @include('admin.components.header')
            <div class="p-4">@yield('content')</div>
        </div>
    </div>
</body>

</html>
