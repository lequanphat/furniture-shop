<header class="header-area header-responsive-padding ">
    <div class="header-bottom sticky-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="logo">
                        <a href="#"><img src="{{ asset('images/logo/logo.png') }}" alt="logo"></a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block d-flex justify-content-center">
                    <div class="main-menu text-center">
                        <nav>
                            <ul>
                                <li><a href="/">HOME</a>
                                </li>
                                <li><a href="/shop">SHOP</a>
                                </li>
                                <li><a href="#">PAGES</a>
                                    <ul class="sub-menu-style">
                                        <li><a href="#">about us </a></li>
                                        <li><a href="#">cart page</a></li>
                                        <li><a href="#">checkout </a></li>
                                    </ul>
                                </li>
                                <li><a href="/about">ABOUT</a></li>
                                <li><a href="/contact">CONTACT US</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="header-action-wrap">
                        <div class="header-action-style header-search-1">
                            <a class="search-toggle" href="#">
                                <i class="pe-7s-search s-open"></i>
                                <i class="pe-7s-close s-close"></i>
                            </a>
                            <div class="search-wrap-1">
                                <form action="#">
                                    <input placeholder="Search products…" type="text">
                                    <button class="button-search"><i class="pe-7s-search"></i></button>
                                </form>
                            </div>
                        </div>
                        @if (Auth::user())
                            <div class="header-action-style">
                                <a title="Account" href="/account"><i class="pe-7s-user"></i></a>
                            </div>
                        @endif
                        <div class="header-action-style header-action-cart">
                            <a class="cart-active" href="#"><i class="pe-7s-shopbag"></i>
                                <span class="product-count bg-black">01</span>
                            </a>
                        </div>
                        @if (!Auth::user())
                            <a href="/login" class="ms-2">
                                <span> Sign in</span>
                            </a>
                        @endif
                        <div class="header-action-style d-block d-lg-none">
                            <a class="mobile-menu-active-button" href="#"><i class="pe-7s-menu"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- Mobile Menu start -->
<div class="off-canvas-active">
    <a class="off-canvas-close"><i class=" ti-close "></i></a>
    <div class="off-canvas-wrap">
        <div class="mobile-menu-wrap off-canvas-margin-padding-2">
            <div id="mobile-menu" class="slinky-mobile-menu text-left">
                <ul>
                    <li>
                        <a href="/">HOME</a>
                    </li>
                    <li>
                        <a href="/shop">SHOP</a>
                    </li>
                    <li>
                        <a href="#">PAGES </a>
                        <ul>
                            <li><a href="#">About Us </a></li>
                            <li><a href="#">Cart Page</a></li>
                            <li><a href="#">Checkout </a></li>
                            <li><a href="/account">My Account</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/about">ABOUT US</a>
                    </li>
                    <li>
                        <a href="/contact">CONTACT US</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
