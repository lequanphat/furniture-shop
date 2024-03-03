<!DOCTYPE html>
<html lang="en">
@include('components.head')

<body>
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
