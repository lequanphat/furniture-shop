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
        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8 p-r-0 title-margin-right">
                            <div class="page-header">
                                <div class="page-title">
                                    <h1>Hello, Welcome {{ session('user')->displayName }}</h1>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-4 p-l-0 title-margin-left">
                            <div class="page-header">
                                <div class="page-title">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Home</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('admin.components.link-script')
</body>

</html>
