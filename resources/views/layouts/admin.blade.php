<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

@include('admin.components.head')

<body>
    <script src="{{ asset('vendor/tabler/tabler.min.js') }}" defer></script>
    <div class="page">
        @include('admin.components.navbar')
        <div class="page-wrapper">
            @yield('content')

        </div>
    </div>
    @include('admin.components.link-script')
</body>

</html>
