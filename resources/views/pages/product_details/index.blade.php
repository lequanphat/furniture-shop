@extends('layouts.app')
@section('content')
    {{-- Mini cart --}}
    @include('components.mini-cart')
    {{-- Head banner --}}
    @include('components.head-banner')

    <div class="product-details-area pb-100 pt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-details-img-wrap product-details-vertical-wrap" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="product-details-small-img-wrap">
                            <div class="swiper-container product-details-small-img-slider-1 pd-small-img-style">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="product-details-small-img">
                                            <img src="{{ asset('images/product-details/pro-details-small-img-1.png') }}"
                                                alt="Product Thumnail">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="product-details-small-img">
                                            <img src="{{ asset('images/product-details/pro-details-small-img-2.png') }}"
                                                alt="Product Thumnail">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="product-details-small-img">
                                            <img src="{{ asset('images/product-details/pro-details-small-img-3.png') }}"
                                                alt="Product Thumnail">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="product-details-small-img">
                                            <img src="{{ asset('images/product-details/pro-details-small-img-4.png') }}"
                                                alt="Product Thumnail">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="product-details-small-img">
                                            <img src="{{ asset('images/product-details/pro-details-small-img-5.png') }}"
                                                alt="Product Thumnail">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pd-prev pd-nav-style"> <i class="ti-angle-up"></i></div>
                            <div class="pd-next pd-nav-style"> <i class="ti-angle-down"></i></div>
                        </div>
                        <div class="swiper-container product-details-big-img-slider-1 pd-big-img-style">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{ asset('images/product-details/pro-details-zoom-img-1.png') }}">
                                                <img src="{{ asset('images/product-details/pro-details-large-img-1.png') }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <a class="easyzoom-pop-up img-popup"
                                            href="{{ asset('images/product-details/pro-details-large-img-1.png') }}">
                                            <i class="pe-7s-search"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{ asset('images/product-details/pro-details-zoom-img-2.png') }}">
                                                <img src="{{ asset('images/product-details/pro-details-large-img-2.png') }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <a class="easyzoom-pop-up img-popup"
                                            href="{{ asset('images/product-details/pro-details-large-img-2.png') }}">
                                            <i class="pe-7s-search"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{ asset('images/product-details/pro-details-zoom-img-3.png') }}">
                                                <img src="{{ asset('images/product-details/pro-details-large-img-3.png') }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <a class="easyzoom-pop-up img-popup"
                                            href="{{ asset('images/product-details/pro-details-large-img-3.png') }}">
                                            <i class="pe-7s-search"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{ asset('images/product-details/pro-details-zoom-img-4.png') }}">
                                                <img src="{{ asset('images/product-details/pro-details-large-img-4.png') }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <a class="easyzoom-pop-up img-popup"
                                            href="{{ asset('images/product-details/pro-details-large-img-4.png') }}">
                                            <i class="pe-7s-search"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{ asset('images/product-details/pro-details-zoom-img-5.png') }}">
                                                <img src="{{ asset('images/product-details/pro-details-large-img-5.png') }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <a class="easyzoom-pop-up img-popup"
                                            href="{{ asset('images/product-details/pro-details-large-img-5.png') }}">
                                            <i class="pe-7s-search"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-details-content" data-aos="fade-up" data-aos-delay="400">
                        <h2>New Modern Chair</h2>
                        <div class="product-details-price">
                            <span class="old-price">$25.89 </span>
                            <span class="new-price">$20.25</span>
                        </div>
                        <div class="product-details-review">
                            <div class="product-rating">
                                <i class=" ti-star"></i>
                                <i class=" ti-star"></i>
                                <i class=" ti-star"></i>
                                <i class=" ti-star"></i>
                                <i class=" ti-star"></i>
                            </div>
                            <span>( 1 Customer Review )</span>
                        </div>
                        <div class="product-color product-color-active product-details-color">
                            <span>Color :</span>
                            <ul>
                                <li><a title="Pink" class="pink" href="#">pink</a></li>
                                <li><a title="Yellow" class="active yellow" href="#">yellow</a></li>
                                <li><a title="Purple" class="purple" href="#">purple</a></li>
                            </ul>
                        </div>
                        <div class="product-details-action-wrap">
                            <div class="product-quality">
                                <input class="cart-plus-minus-box input-text qty text" name="qtybutton" value="1">
                            </div>
                            <div class="single-product-cart btn-hover">
                                <a href="#">Add to cart</a>
                            </div>
                            <div class="single-product-wishlist">
                                <a title="Wishlist" href="wishlist.html"><i class="pe-7s-like"></i></a>
                            </div>
                            <div class="single-product-compare">
                                <a title="Compare" href="#"><i class="pe-7s-shuffle"></i></a>
                            </div>
                        </div>
                        <div class="product-details-meta">
                            <ul>
                                <li><span class="title">SKU:</span> Ch-256xl</li>
                                <li><span class="title">Category:</span>
                                    <ul>
                                        <li><a href="#">Office</a>,</li>
                                        <li><a href="#">Home</a></li>
                                    </ul>
                                </li>
                                <li><span class="title">Tags:</span>
                                    <ul class="tag">
                                        <li><a href="#">Furniture</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="social-icon-style-4">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="description-review-area pb-85">
        <div class="container">
            <div class="description-review-topbar nav" data-aos="fade-up" data-aos-delay="200">
                <a class="active" data-bs-toggle="tab" href="#des-details1"> Description </a>
                <a data-bs-toggle="tab" href="#des-details2" class=""> Information </a>
            </div>
            <div class="tab-content">
                <div id="des-details1" class="tab-pane active">
                    <div class="product-description-content text-center">
                        <p data-aos="fade-up" data-aos-delay="200">Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                            veniam, quis nostrud exercita ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                            irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        </p>
                        <p data-aos="fade-up" data-aos-delay="400">Excepteur sint occaecat cupidatat non proident, sunt in
                            culpa qui officia deserunt mollit anim id est laborum. Sed ut per unde omnis iste natus error
                            sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo</p>
                    </div>
                </div>
                <div id="des-details2" class="tab-pane">
                    <div class="specification-wrap table-responsive">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="width1">Brands</td>
                                    <td>Airi, Brand, Draven, Skudmart, Yena</td>
                                </tr>
                                <tr>
                                    <td class="width1">Color</td>
                                    <td>Blue, Gray, Pink</td>
                                </tr>
                                <tr>
                                    <td class="width1">Size</td>
                                    <td>L, M, S, XL, XXL</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Related products --}}
    @include('pages.product_details.related-products')
@endsection
