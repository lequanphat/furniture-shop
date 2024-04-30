<div class="product-area pb-60">
    <div class="container">
        <div class="section-title-tab-wrap mb-75">
            <div class="section-title-2">
                <h2>Hot Products</h2>
            </div>
            <div class="tab-style-1 nav">
                <a class="active" href="#pro-1" data-bs-toggle="tab">Best Sellers</a>
                <a href="#pro-2" data-bs-toggle="tab" class="">Latest Products</a>
            </div>
        </div>
        <div class="tab-content jump">
            <div id="pro-1" class="tab-pane active">
                <div class="row" id="pro-1-content">
                    @foreach ($best_seller_products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-wrap mb-35">
                                <div class="custom-product-img  product-img img-zoom mb-25">
                                    <a href="/products/{{ $product->product_id }}">
                                        <img src="{{ $product->detailed_product->image }}" alt="">
                                    </a>
                                    <div class="product-badge badge-top badge-right badge-pink">
                                        <span>{{ $product->detailed_product->total_discount_percentage != 0 ? '-' . $product->detailed_product->total_discount_percentage . '%' : '' }}</span>
                                    </div>
                                    @if ($product->total_quantities == 0)
                                        <div class="custom-product-badge product-badge badge-top badge-left badge-pink">
                                            <span>Sold out</span>
                                        </div>
                                    @endif
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
                                            class="old-price">{{ number_format($product->detailed_product->original_price, 0, '.', ',') }}đ</span>
                                        <span
                                            class="new-price">{{ number_format($product->detailed_product->original_price - ($product->detailed_product->original_price * $product->detailed_product->total_discount_percentage) / 100, 0, '.', ',') }}đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="pro-2" class="tab-pane">
                <div class="row" id="pro-2-content">
                    @foreach ($latest_products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-wrap mb-35">
                                <div class="custom-product-img  product-img img-zoom mb-25">
                                    <a href="/products/{{ $product->product_id }}">
                                        <img src="{{ $product->detailed_product->image }}" alt="">
                                    </a>
                                    <div class="product-badge badge-top badge-right badge-pink">
                                        <span>{{ $product->detailed_product->total_discount_percentage != 0 ? '-' . $product->detailed_product->total_discount_percentage . '%' : '' }}</span>
                                    </div>
                                    @if ($product->total_quantities == 0)
                                        <div class="custom-product-badge product-badge badge-top badge-left badge-pink">
                                            <span>Sold out</span>
                                        </div>
                                    @endif
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
                                            class="old-price">{{ number_format($product->detailed_product->original_price, 0, '.', ',') }}đ</span>
                                        <span
                                            class="new-price">{{ number_format($product->detailed_product->original_price - ($product->detailed_product->original_price * $product->detailed_product->total_discount_percentage) / 100, 0, '.', ',') }}đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
