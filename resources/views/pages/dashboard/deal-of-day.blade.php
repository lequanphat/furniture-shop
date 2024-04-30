<div class="product-area pb-95">
    <div class="container">
        <div class="section-border section-border-margin-1">
            <div class="section-title-timer-wrap bg-white">
                <div class="section-title-1">
                    <h2>Deal Of The Day</h2>
                </div>
            </div>
        </div>
        <div class="product-slider-active-1 swiper-container">
            <div class="swiper-wrapper" id="deal_of_day">
                @foreach ($deal_products as $product)
                    <div class="swiper-slide">
                        <div class="product-wrap">
                            <div class="custom-product-img product-img img-zoom mb-25">
                                <a href="/products/{{ $product->product_id }}">
                                    <img src="{{ $product->url }}" alt="">
                                </a>
                                <div class="product-badge badge-top badge-right badge-pink">
                                    <span>{{ $product->discount_percent }}%</span>
                                </div>
                                <div class="product-action-wrap">
                                    <a href="/products/{{ $product->product_id }}" class="product-action-btn-1"
                                        title="Wishlist"><i class="pe-7s-like"></i></a>
                                    <a href="/products/{{ $product->product_id }}" class="product-action-btn-1"
                                        title="Quick View">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="product-content">
                                <h3><a href="/products/{{ $product->product_id }}">{{ $product->name }}</a></h3>
                                <div class="product-price">
                                    <span
                                        class="old-price">{{ number_format($product->old_price, 0, '.', ',') }}đ</span>
                                    <span
                                        class="new-price">{{ number_format($product->new_price, 0, '.', ',') }}đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
            <div class="product-prev-1 product-nav-1"><i class="fa fa-angle-left"></i></div>
            <div class="product-next-1 product-nav-1"><i class="fa fa-angle-right"></i></div>
        </div>
    </div>
</div>
