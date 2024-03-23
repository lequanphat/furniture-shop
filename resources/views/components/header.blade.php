<header class="header-area header-responsive-padding ">
    <div class="header-bottom sticky-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="logo">
                        <a href="index.html"><img src="{{ asset('images/logo/logo.png') }}" alt="logo"></a>
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
                        <div class="header-action-style">
                            <a title="Login Register" href="#"><i class="pe-7s-user"></i></a>
                        </div>
                        <div class="header-action-style">
                            <a title="Wishlist" href="#"><i class="pe-7s-like"></i></a>
                        </div>
                        <div class="header-action-style header-action-cart">
                            <a class="cart-active" href="#"><i class="pe-7s-shopbag"></i>
                                <span class="product-count bg-black">01</span>
                            </a>
                        </div>
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
        <div class="welcome-text off-canvas-margin-padding">
            <p>Default Welcome Msg! </p>
        </div>
        <div class="mobile-menu-wrap off-canvas-margin-padding-2">
            <div id="mobile-menu" class="slinky-mobile-menu text-left">
                <ul>
                    <li>
                        <a href="#">HOME</a>
                        <ul>
                            <li><a href="#">Home version 1 </a></li>
                            <li><a href="#">Home version 2</a></li>
                            <li><a href="#">Home version 3</a></li>
                            <li><a href="#">Home version 4</a></li>
                            <li><a href="#">Home version 5</a></li>
                            <li><a href="#">Home version 6</a></li>
                            <li><a href="#">Home version 7</a></li>
                            <li><a href="#">Home version 8</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">SHOP</a>
                        <ul>
                            <li>
                                <a href="#">Shop Layout</a>
                                <ul>
                                    <li><a href="#">Standard Style</a></li>
                                    <li><a href="#">Shop Grid Sidebar</a></li>
                                    <li><a href="#">Shop List Style</a></li>
                                    <li><a href="#">Shop List Sidebar</a></li>
                                    <li><a href="#">Shop Right Sidebar</a></li>
                                    <li><a href="#">Store Location</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Product Layout</a>
                                <ul>
                                    <li><a href="#">Tab Style 1</a></li>
                                    <li><a href="#">Tab Style 2</a></li>
                                    <li><a href="#">Gallery style </a></li>
                                    <li><a href="#">Affiliate style</a></li>
                                    <li><a href="#">Group Style</a></li>
                                    <li><a href="#">Fixed Image Style </a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">PAGES </a>
                        <ul>
                            <li><a href="#">About Us </a></li>
                            <li><a href="#">Cart Page</a></li>
                            <li><a href="#">Checkout </a></li>
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Wishlist </a></li>
                            <li><a href="#">Compare </a></li>
                            <li><a href="#">Contact us </a></li>
                            <li><a href="#">Login / Register </a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">BLOG </a>
                        <ul>
                            <li><a href="#">Blog Standard </a></li>
                            <li><a href="#">Blog Sidebar</a></li>
                            <li><a href="#">Blog Details</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">ABOUT US</a>
                    </li>
                    <li>
                        <a href="#">CONTACT US</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="language-currency-wrap language-currency-wrap-modify">
            <div class="currency-wrap border-style">
                <a class="currency-active" href="#">$ Dollar (US) <i class=" ti-angle-down "></i></a>
                <div class="currency-dropdown">
                    <ul>
                        <li><a href="#">Taka (BDT) </a></li>
                        <li><a href="#">Riyal (SAR) </a></li>
                        <li><a href="#">Rupee (INR) </a></li>
                    </ul>
                </div>
            </div>
            <div class="language-wrap">
                <a class="language-active" href="#"><img src="{{ asset('images/icon-img/flag.png') }}"
                        alt=""> English <i class=" ti-angle-down "></i></a>
                <div class="language-dropdown">
                    <ul>
                        <li><a href="#"><img src="{{ asset('images/icon-img/flag.png') }}"
                                    alt="">English
                            </a></li>
                        <li><a href="#"><img src="{{ asset('images/icon-img/spanish.png') }}"
                                    alt="">Spanish</a></li>
                        <li><a href="#"><img src="{{ asset('images/icon-img/arabic.png') }}"
                                    alt="">Arabic
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
