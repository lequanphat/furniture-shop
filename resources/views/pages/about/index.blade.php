@extends('layouts.app')
@section('content')
    <!-- mini cart start -->
    <div class="sidebar-cart-active">
        <div class="sidebar-cart-all">
            <a class="cart-close" href="#"><i class="pe-7s-close"></i></a>
            <div class="cart-content">
                <h3>Shopping Cart</h3>
                <ul>
                    <li>
                        <div class="cart-img">
                            <a href="#"><img src="{{ asset('images/cart/cart-1.jpg') }}" alt="" /></a>
                        </div>
                        <div class="cart-title">
                            <h4><a href="#">Stylish Swing Chair</a></h4>
                            <span> 1 × $49.00 </span>
                        </div>
                        <div class="cart-delete">
                            <a href="#">×</a>
                        </div>
                    </li>
                    <li>
                        <div class="cart-img">
                            <a href="#"><img src="{{ asset('images/cart/cart-2.jpg') }}" alt="" /></a>
                        </div>
                        <div class="cart-title">
                            <h4><a href="#">Modern Chairs</a></h4>
                            <span> 1 × $49.00 </span>
                        </div>
                        <div class="cart-delete">
                            <a href="#">×</a>
                        </div>
                    </li>
                </ul>
                <div class="cart-total">
                    <h4>Subtotal: <span>$170.00</span></h4>
                </div>
                <div class="cart-btn btn-hover">
                    <a class="theme-color" href="cart.html">view cart</a>
                </div>
                <div class="checkout-btn btn-hover">
                    <a class="theme-color" href="checkout.html">checkout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-area bg-gray-4 breadcrumb-padding-1">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <h2 data-aos="fade-up" data-aos-delay="200">About Us</h2>
                <ul data-aos="fade-up" data-aos-delay="400">
                    <li><a href="index.html">Home</a></li>
                    <li><i class="ti-angle-right"></i></li>
                    <li>About Us</li>
                </ul>
            </div>
        </div>
        <div class="breadcrumb-img-1" data-aos="fade-right" data-aos-delay="200">
            <img src="{{ asset('images/banner/breadcrumb-1.png') }}" alt="" />
        </div>
        <div class="breadcrumb-img-2" data-aos="fade-left" data-aos-delay="200">
            <img src="{{ asset('images/banner/breadcrumb-2.png') }}" alt="" />
        </div>
    </div>
    <div class="about-us-area pt-100 pb-100">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-6">
                    <div class="about-content text-center">
                        <h2 data-aos="fade-up" data-aos-delay="200">Furniture</h2>
                        <h1 data-aos="fade-up" data-aos-delay="300">Best Furniture</h1>
                        <p data-aos="fade-up" data-aos-delay="400">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                            do eiusmod tempor incidi ut labore et dolore magna aliqua. Ut
                            enim ad minim venia quis nostrud exercitation ullamco laboris
                            nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                            in reprehenderit
                        </p>
                        <p class="mrg-inc" data-aos="fade-up" data-aos-delay="500">
                            in voluptate velit esse cillum dolore eu fugiat nulla
                            pariatur. Excepteur sint occaecat cupidatat non proident, sunt
                            in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <div class="btn-style-3 btn-hover" data-aos="fade-up" data-aos-delay="600">
                            <a class="btn border-radius-none" href="product-details.html">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-img" data-aos="fade-up" data-aos-delay="400">
                        <img src="{{ asset('images/banner/about-us.png') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-area pb-100">
        <div class="bg-img bg-padding-2" style="background-image: url({{ asset('images/bg/bg-2.png') }})">
            <div class="container">
                <div class="banner-content-5 banner-content-5-static">
                    <span data-aos="fade-up" data-aos-delay="200">Up To 40% Off</span>
                    <h1 data-aos="fade-up" data-aos-delay="400">
                        New Furniture <br />Sofa Set
                    </h1>
                    <div class="btn-style-3 btn-hover" data-aos="fade-up" data-aos-delay="600">
                        <a class="btn border-radius-none" href="product-details.html">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="testimonial-area pb-100">
        <div class="container">
            <div class="section-title-2 st-border-center text-center mb-75" data-aos="fade-up" data-aos-delay="200">
                <h2>Testimonial</h2>
            </div>
            <div class="testimonial-active swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="single-testimonial" data-aos="fade-up" data-aos-delay="200">
                            <div class="testimonial-img">
                                <img src="{{ asset('images/testimonial/client-1.png') }}" alt="" />
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectet adipisicing elit, sed
                                do eiusmod tempo incididunt ut labore et dolore.
                            </p>
                            <div class="testimonial-info">
                                <h4>Amrita Sha</h4>
                                <span> Our Client.</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="single-testimonial" data-aos="fade-up" data-aos-delay="400">
                            <div class="testimonial-img">
                                <img src="{{ asset('images/testimonial/client-2.png') }}" alt="" />
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectet adipisicing elit, sed
                                do eiusmod tempo incididunt ut labore et dolore.
                            </p>
                            <div class="testimonial-info">
                                <h4>Andi Lane</h4>
                                <span> Designer.</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="single-testimonial" data-aos="fade-up" data-aos-delay="600">
                            <div class="testimonial-img">
                                <img src="{{ asset('images/testimonial/client-1.png') }}" alt="" />
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectet adipisicing elit, sed
                                do eiusmod tempo incididunt ut labore et dolore.
                            </p>
                            <div class="testimonial-info">
                                <h4>Ted Ellison</h4>
                                <span> Developer.</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="single-testimonial">
                            <div class="testimonial-img">
                                <img src="{{ asset('images/testimonial/client-2.png') }}" alt="" />
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectet adipisicing elit, sed
                                do eiusmod tempo incididunt ut labore et dolore.
                            </p>
                            <div class="testimonial-info">
                                <h4>Aliah Pitts</h4>
                                <span> Customer.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="funfact-area bg-img pt-100 pb-70" style="background-image: url(assets/images/bg/bg-4.png)">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                    <div class="single-funfact text-center mb-30" data-aos="fade-up" data-aos-delay="200">
                        <div class="funfact-img">
                            <img src="{{ asset('images/icon-img/client.png') }}" alt="" />
                        </div>
                        <h2 class="count">120</h2>
                        <span>Happy Clients</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                    <div class="single-funfact text-center mb-30" data-aos="fade-up" data-aos-delay="400">
                        <div class="funfact-img">
                            <img src="{{ asset('images/icon-img/award.png') }}" alt="" />
                        </div>
                        <h2 class="count">90</h2>
                        <span>Award Winning</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                    <div class="single-funfact text-center mb-30" data-aos="fade-up" data-aos-delay="600">
                        <div class="funfact-img">
                            <img src="{{ asset('images/icon-img/item.png') }}" alt="" />
                        </div>
                        <h2 class="count">230</h2>
                        <span>Totel Items</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                    <div class="single-funfact text-center mb-30 mrgn-none" data-aos="fade-up" data-aos-delay="800">
                        <div class="funfact-img">
                            <img src="{{ asset('images/icon-img/cup.png') }}" alt="" />
                        </div>
                        <h2 class="count">350</h2>
                        <span>Cups of Coffee</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="team-area pt-100 pb-70">
        <div class="container">
            <div class="section-title-2 st-border-center text-center mb-75" data-aos="fade-up" data-aos-delay="200">
                <h2>Our Staff</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="single-team-wrap text-center mb-30" data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ asset('images/team/team-1.png') }}" alt="" />
                        <div class="team-info-position">
                            <div class="team-info">
                                <h3>Kari Rasmus</h3>
                                <span>Sales Man</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="single-team-wrap text-center mb-30" data-aos="fade-up" data-aos-delay="400">
                        <img src="{{ asset('images/team/team-2.png') }}" alt="" />
                        <div class="team-info-position">
                            <div class="team-info">
                                <h3>Kari Rasmus</h3>
                                <span>Sales Man</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="single-team-wrap text-center mb-30" data-aos="fade-up" data-aos-delay="600">
                        <img src="{{ asset('images/team/team-3.png') }}" alt="" />
                        <div class="team-info-position">
                            <div class="team-info">
                                <h3>Kari Rasmus</h3>
                                <span>Sales Man</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="subscribe-area pb-100">
        <div class="container">
            <div class="section-title-3 text-center mb-55" data-aos="fade-up" data-aos-delay="200">
                <h2>Join With Us!</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit seddo
                    eiusmod tempor incididunt ut labore
                </p>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div id="mc_embed_signup" class="subscribe-form" data-aos="fade-up" data-aos-delay="400">
                        <form id="mc-embedded-subscribe-form" class="validate subscribe-form-style" novalidate=""
                            target="_blank" name="mc-embedded-subscribe-form" method="post" action="#">
                            <div id="mc_embed_signup_scroll" class="mc-form">
                                <input class="email" type="email" required="" placeholder="Email address…"
                                    name="EMAIL" value="" />
                                <div class="mc-news" aria-hidden="true">
                                    <input type="text" value="" tabindex="-1"
                                        name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef" />
                                </div>
                                <div class="clear">
                                    <input id="mc-embedded-subscribe" class="button" type="submit" name="subscribe"
                                        value="Subscribe Now" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
