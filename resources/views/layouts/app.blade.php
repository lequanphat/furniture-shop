<!DOCTYPE html>
<html lang="en">
@include('components.head')

<body>
    <div id="asset" data-asset="{{ asset('') }}"></div>
    <div class="main-wrapper main-wrapper-2">
        @include('components.header')
        {{-- Mini cart --}}


        <!-- All JS is here -->
        <script src="{{ asset('js/vendor/modernizr-3.11.7.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/jquery-3.6.0.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/jquery-migrate-3.3.2.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/popper.min.js') }}" defer></script>
        <script src="{{ asset('js/vendor/bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('js/plugins/wow.js') }}" defer></script>
        <script src="{{ asset('js/plugins/scrollup.js') }}" defer></script>
        <script src="{{ asset('js/plugins/aos.js') }}" defer></script>
        <script src="{{ asset('js/plugins/magnific-popup.js') }}" defer></script>
        <script src="{{ asset('js/plugins/jquery.syotimer.min.js') }}" defer></script>
        <script src="{{ asset('js/plugins/swiper.min.js') }}" defer></script>
        <script src="{{ asset('js/plugins/imagesloaded.pkgd.min.js') }}" defer></script>
        <script src="{{ asset('js/plugins/isotope.pkgd.min.js') }}" defer></script>
        <script src="{{ asset('js/plugins/jquery-ui.js') }}" defer></script>
        <script src="{{ asset('js/plugins/jquery-ui-touch-punch.js') }}" defer></script>
        <script src="{{ asset('js/plugins/jquery.nice-select.min.js') }}" defer></script>
        <script src="{{ asset('js/plugins/waypoints.min.js') }}" defer></script>
        <script src="{{ asset('js/plugins/jquery.counterup.js') }}" defer></script>
        <script src="{{ asset('js/plugins/select2.min.js') }}" defer></script>
        <script src="{{ asset('js/plugins/easyzoom.js') }}" defer></script>
        <script src="{{ asset('js/plugins/slinky.min.js') }}" defer></script>
        <script src="{{ asset('js/plugins/ajax-mail.js') }}" defer></script>
        {{-- Toastify --}}
        <script src="{{ asset('js/vendor/toastify.min.js') }}" defer></script>
        <!-- Main JS -->
        <script src="{{ asset('js/main.js') }}" defer></script>
        <script src="{{ asset('js/shop_api.js') }}" defer></script>

        <script src="{{ asset('js/profile_api.js') }}" defer></script>
        @include('components.mini-cart')
        @yield('content')

    </div>
    @include('components.footer')
</body>

</html>
