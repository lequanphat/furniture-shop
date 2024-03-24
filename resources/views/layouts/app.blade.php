<!DOCTYPE html>
<html lang="en">
@include('components.head')

<body>
    <div class="main-wrapper main-wrapper-2">
        @include('components.header')
        @yield('content')

        <!-- All JS is here -->
        <script src="{{ asset('js/vendor/modernizr-3.11.7.min.js') }}"></script>
        <script src="{{ asset('js/vendor/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/vendor/jquery-migrate-3.3.2.min.js') }}"></script>
        <script src="{{ asset('js/vendor/popper.min.js') }}"></script>
        <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/plugins/wow.js') }}"></script>
        <script src="{{ asset('js/plugins/scrollup.js') }}"></script>
        <script src="{{ asset('js/plugins/aos.js') }}"></script>
        <script src="{{ asset('js/plugins/magnific-popup.js') }}"></script>
        <script src="{{ asset('js/plugins/jquery.syotimer.min.js') }}"></script>
        <script src="{{ asset('js/plugins/swiper.min.js') }}"></script>
        <script src="{{ asset('js/plugins/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{ asset('js/plugins/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('js/plugins/jquery-ui.js') }}"></script>
        <script src="{{ asset('js/plugins/jquery-ui-touch-punch.js') }}"></script>
        <script src="{{ asset('js/plugins/jquery.nice-select.min.js') }}"></script>
        <script src="{{ asset('js/plugins/waypoints.min.js') }}"></script>
        <script src="{{ asset('js/plugins/jquery.counterup.js') }}"></script>
        <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
        <script src="{{ asset('js/plugins/easyzoom.js') }}"></script>
        <script src="{{ asset('js/plugins/slinky.min.js') }}"></script>
        <script src="{{ asset('js/plugins/ajax-mail.js') }}"></script>
        <!-- Main JS -->
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{asset('js/profile_api.js')}}"></script>
    </div>
    @include('components.footer')
</body>

</html>
