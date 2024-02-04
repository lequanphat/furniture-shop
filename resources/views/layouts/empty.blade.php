<!DOCTYPE html>
<html lang="en">
@include('components.head')

<body>
    @if (session('user'))
        <script>
            window.location = "/";
        </script>
    @endif
    <div class="empty_layout"> @yield('content')</div>
</body>

</html>
