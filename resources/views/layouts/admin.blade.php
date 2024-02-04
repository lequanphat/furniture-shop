<!DOCTYPE html>
<html lang="en">
@include('admin.components.head')

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

    <div>
        @include('admin.components.navbar')
        @include('admin.components.header')
        @yield('content')
    </div>

    @include('admin.components.link-script')
</body>

</html>
