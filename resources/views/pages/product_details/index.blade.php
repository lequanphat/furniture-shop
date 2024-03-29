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
                                <div class="js-images-list swiper-wrapper">
                                    @foreach ($detailed_product->images as $image)
                                        <div class="swiper-slide">
                                            <div class="product-details-small-img">
                                                <img src="{{ $image->url }}" alt="Product Thumnail">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="pd-prev pd-nav-style"> <i class="ti-angle-up"></i></div>
                            <div class="pd-next pd-nav-style"> <i class="ti-angle-down"></i></div>
                        </div>
                        <div class="swiper-container product-details-big-img-slider-1 pd-big-img-style">
                            <div class="js-images-preview swiper-wrapper">
                                @foreach ($detailed_product->images as $image)
                                    <div class="swiper-slide">
                                        <div class="easyzoom-style">
                                            <div class="easyzoom easyzoom--overlay">

                                                <a href="{{ $image->url }}">
                                                    <img src="{{ $image->url }}" alt="">
                                                </a>
                                            </div>
                                            <a class="easyzoom-pop-up img-popup" href="{{ $image->url }}">
                                                <i class="pe-7s-search"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-details-content" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="js-product-name">
                            {{ $detailed_product->name }}
                        </h2>
                        @php
                            $today = now();
                            $discount_percentage = $detailed_product->product_discounts
                                ->where('discount.start_date', '<=', $today)
                                ->where('discount.end_date', '>=', $today)
                                ->sum('discount.percentage');
                        @endphp
                        <div class="product-details-price">
                            @if ($discount_percentage > 0)
                                <span class="old-price">
                                    {{ number_format($detailed_product->original_price, 0, '.', ',') }}đ</span>
                            @endif
                            <span class="js-product-price  new-price ">
                                {{ number_format($detailed_product->original_price - ($detailed_product->original_price * $discount_percentage) / 100, 0, '.', ',') }}đ
                            </span>

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
                        {{-- temporary custom  --}}
                        <div class="d-flex my-4 " style="flex-wrap: wrap;">
                            @foreach ($product->detailed_products as $dt_product)
                                <div class="detailed-product-tag d-flex p-2 me-3 mb-3 @if ($dt_product->sku == $detailed_product->sku) active @endi @endif"
                                    data-sku="{{ $dt_product->sku }}" data-id="{{ $product->product_id }}">
                                    <div class="me-2"
                                        style="width: 20px; height:20px; background-color: {{ $dt_product->color->code }}">
                                    </div>
                                    <span>{{ $dt_product->size }}</span>
                                </div>
                            @endforeach
                        </div>
                        {{--  temporary custom --}}
                        <div class="product-details-action-wrap">
                            <div class="product-quality">
                                <input class="cart-plus-minus-box input-text qty text" name="qtybutton" value="1">
                            </div>
                            <div class="single-product-cart btn-hover">
                                <a href="#">Add to cart</a>
                            </div>
                            <div class="single-product-wishlist">
                                <span>(12 products available)</span>
                            </div>

                        </div>
                        <div class="product-details-meta">
                            <ul>
                                <li><span class="title ">SKU:</span>
                                    <span class="js-product-sku">{{ $detailed_product->sku }}</span>

                                <li><span class="title">Category:</span>
                                    <ul>
                                        <li><a>{{ $product->category->name }}</a></li>
                                    </ul>
                                </li>
                                <li><span class="title">Tags:</span>
                                    <ul>
                                        @foreach ($product->product_tags as $product_tag)
                                            <li class="me-2"><a>#{{ $product_tag->tag->name }} </a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
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
                        <div data-aos="fade-up" data-aos-delay="400">
                            {!! $detailed_product->description !!}
                        </div>
                    </div>
                </div>
                <div id="des-details2" class="tab-pane">
                    <div class="specification-wrap table-responsive">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="width1">Brands</td>
                                    <td>{{ $product->brand->name }}</td>
                                </tr>
                                <tr>
                                    <td class="width1">Color</td>
                                    <td>{{ $detailed_product->color->name }}</td>
                                </tr>
                                <tr>
                                    <td class="width1">Size</td>
                                    <td>
                                        {{ $detailed_product->size }}
                                    </td>
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
