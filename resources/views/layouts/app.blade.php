<!DOCTYPE html>
<html lang="en">
@include('components.head')

<body>
    @if (session('user') && is_object(session('user')))
        @if (session('user')->type != 'user')
            <script>
                window.location = "/admin";
            </script>
        @endif
    @else
        <script>
            window.location = "/login";
        </script>
    @endif
    @include('components.header')
    <div class="">
        @yield('content')
    </div>
    @include('components.footer')


    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/tiny-slider.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
