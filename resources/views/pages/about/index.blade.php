@extends('layouts.app')
@section('content')
    {{-- Head banner --}}
    @include('components.head-banner')

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
    {{-- Banner --}}
    @include('pages.about.banner')
    {{-- Testimonial --}}
    @include('pages.about.testimonial')
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
    {{-- Our staff --}}
    @include('pages.about.our-staff')
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
