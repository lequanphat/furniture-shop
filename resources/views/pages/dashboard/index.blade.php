@extends('layouts.app')
@section('content')
    {{-- Slider --}}
    @include('pages.dashboard.slider')

    <div class="banner-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="banner-wrap mb-30">
                        <a href="/products/1"><img src="{{ asset('images/banner/banner-1.png') }}" alt=""></a>
                        <div class="banner-content-1">
                            <h5>new arrival</h5>
                            <h3>Office Chair</h3>
                            <div class="banner-btn">
                                <a href="/products/1">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="banner-wrap mb-30">
                        <a href="/products/1"><img src="{{ asset('images/banner/banner-2.png') }}" alt=""></a>
                        <div class="banner-content-1">
                            <h5>new arrival</h5>
                            <h3>Hanging Chair</h3>
                            <div class="banner-btn">
                                <a href="/products/1">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="banner-wrap mb-30">
                        <a href="/products/1"><img src="{{ asset('images/banner/banner-3.png') }}" alt=""></a>
                        <div class="banner-content-1">
                            <h5>new arrival</h5>
                            <h3>Folding Chair</h3>
                            <div class="banner-btn">
                                <a href="/products/1">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Deal of day --}}
    @include('pages.dashboard.deal-of-day')
    {{-- Banner --}}
    @include('pages.dashboard.banner')




    {{-- Hot product --}}
    @include('pages.dashboard.hot-products')
    {{-- Services --}}
    @include('pages.dashboard.services')
@endsection
