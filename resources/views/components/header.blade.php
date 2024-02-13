<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

    <div class="container">
        <a class="navbar-brand" href="/">Furni<span>.</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
            aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav mb-md-0 mb-2 ms-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li><a class="nav-link" href="/shop">Shop</a></li>
                <li><a class="nav-link" href="/about">About us</a></li>
                <li><a class="nav-link" href="/services">Services</a></li>
                <li><a class="nav-link" href="/blog">Blog</a></li>
                <li><a class="nav-link" href="/contact">Contact us</a></li>
            </ul>

            <ul class="custom-navbar-cta navbar-nav mb-md-0 mb-2 ms-5">
                <li><a class="nav-link" href="cart"><img src="images/cart.svg"></a></li>
                @if (session('user') && is_object(session('user')))
                    <li class="p-2 user-info">
                        <ul class="user-details  ">
                            <li><a href="#">Thông tin tài khoản</a></li>
                            <li><a href="/logout">Đăng xuất</a></li>
                        </ul>
                        <img src="images/user.svg">
                    </li>
                @else
                    <li><a href="/login" class="my-2 btn btn-secondary px-3 py-1 text-white">Login</a></li>
                @endif

            </ul>
        </div>
    </div>

</nav>
<!-- End Header/Navigation -->
