<!DOCTYPE html>
<html lang="en">
@include('admin.components.head')

<body class="dark">
    @include('admin.components.link-script')
    <div>
        @include('admin.components.navbar')
        @include('admin.components.header')
        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 p-l-0 title-margin-left">
                            <div class="page-header">
                                <div class="page-title">
                                    <ol class="breadcrumb p-0">
                                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                        @if (isset($page))
                                            <li class="breadcrumb-item active">{{ $page }}</li>
                                        @endif
                                        @if (isset($action))
                                            <li class="breadcrumb-item active">{{ $action }}</li>
                                        @endif

                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

</body>

</html>
