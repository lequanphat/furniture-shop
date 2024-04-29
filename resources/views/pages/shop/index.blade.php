@extends('layouts.app')
@section('content')
    {{-- @include('components.head-banner') --}}

    <div class="shop-area shop-page-responsive  pb-100">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">
                    <div class="shop-topbar-wrapper mb-40">
                        <div class="shop-topbar-left">
                            <div class="showing-item">
                                <span>
                                    {{ 'Showing ' . $products->currentPage() * 9 - 8 . ' - ' . $products->currentPage() * 9 . ' of ' . $products->total() . ' results' }}
                                </span>
                            </div>
                        </div>
                        <div class="shop-topbar-right">
                            <div class="shop-sorting-area">
                                <select id="sort-product" class="nice-select nice-select-style-1">
                                    <option value="default"
                                        @if ($sorted_by == 'default') @selected(true) @endif>Default
                                        Sorting</option>
                                    <option value="price_asc"
                                        @if ($sorted_by == 'price_asc') @selected(true) @endif>Sort by price
                                        ascending</option>
                                    <option value="price_desc"
                                        @if ($sorted_by == 'price_desc') @selected(true) @endif>Sort by price
                                        descending</option>
                                    <option value="latest"
                                        @if ($sorted_by == 'latest') @selected(true) @endif>Sort
                                        by latest</option>
                                    <option value="oldest"
                                        @if ($sorted_by == 'oldest') @selected(true) @endif>Sort
                                        by oldest</option>
                                </select>
                            </div>
                            <div class="shop-view-mode nav">
                                <a class="active" href="#shop-1" data-bs-toggle="tab"><i class=" ti-layout-grid3 "></i> </a>
                                <a href="#shop-2" data-bs-toggle="tab" class=""><i class=" ti-view-list-alt "></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="shop-bottom-area">
                        <div class="tab-content jump">
                            <div id="shop-1" class="tab-pane active">
                                <div id="product-list" class="row">
                                    @foreach ($products as $product)
                                        @php
                                            $today = now();
                                            $detailed_product = $product->detailed_product;
                                        @endphp
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                                                <div class="custom-product-img product-img img-zoom mb-25">
                                                    <a href="/products/{{ $product->product_id }}">
                                                        <img src="{{ $detailed_product->image }}" alt=""
                                                            style="height: 275px">
                                                    </a>
                                                    <div class="product-badge badge-top badge-right badge-pink">
                                                        <span>{{ $detailed_product->total_discount_percentage != 0 ? '-' . $detailed_product->total_discount_percentage . '%' : '' }}</span>
                                                    </div>
                                                    @if ($product->total_quantities == 0)
                                                        <div
                                                            class="custom-product-badge product-badge badge-top badge-left badge-pink">
                                                            <span>Sold out</span>
                                                        </div>
                                                    @endif
                                                    <div class="product-action-wrap">
                                                        <a class="product-action-btn-1" title="Wishlist"><i
                                                                class="pe-7s-like"></i></a>
                                                        <button class="product-action-btn-1" title="Quick View"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            <i class="pe-7s-look"></i>
                                                        </button>
                                                    </div>
                                                    <div class="product-action-2-wrap">
                                                        <button class="product-action-btn-2" title="Add To Cart"><i
                                                                class="pe-7s-cart"></i> Add to cart</button>
                                                    </div>
                                                </div>
                                                <div class="product-content">
                                                    <h3><a>{{ $product->name }}</a>
                                                    </h3>
                                                    <div class="product-price">
                                                        @if ($detailed_product->total_discount_percentage > 0)
                                                            <span class="old-price">
                                                                {{ number_format($detailed_product->original_price, 0, '.', ',') }}đ
                                                            </span>
                                                        @endif
                                                        <span class="new-price">
                                                            {{ number_format($detailed_product->original_price - ($detailed_product->original_price * $detailed_product->total_discount_percentage) / 100, 0, '.', ',') }}đ
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="pagination-style-1" data-aos="fade-up" data-aos-delay="200">
                                    <ul>

                                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                                            <li>
                                                <a class="pagination-item
                                                    {{ $retVal = $i == $products->currentPage() ? 'active' : '' }}"
                                                    href="">{{ $i }}</a>
                                            </li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                            <div id="shop-2" class="tab-pane">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sidebar-wrapper">
                        <div class="sidebar-widget mb-40" data-aos="fade-up" data-aos-delay="200">
                            <div class="search-wrap-2">
                                <form class="search-2-form" action="#">
                                    <input id="search-input" placeholder="Search products..." type="text"
                                        value="{{ $search }}">
                                    <button class="button-search"><i class=" ti-search "></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-widget sidebar-widget-border mb-40 pb-35" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="sidebar-widget-title mb-30">
                                <h3>Filter By Price</h3>
                            </div>
                            <div class="price-filter">
                                <div class="price-input">
                                    <div class="field">
                                        <input type="text" class="input-min" value="0đ" data-value="0" readonly>
                                    </div>
                                    <div class="separator">-</div>
                                    <div class="field">
                                        <input type="text" class="input-max" value="100,000,000đ" data-value="100000000"
                                            readonly>
                                    </div>
                                </div>
                                <div class="slider">
                                    <div class="progress"></div>
                                </div>
                                <div class="range-input">
                                    <input type="range" name="" id="min" class="range-min"
                                        min="0" max="100000000" value="0">
                                    <input type="range" name="" id="max" class="range-max"
                                        min="0" max="100000000" value="100000000">
                                </div>
                            </div>
                        </div>



                        <div class="sidebar-widget sidebar-widget-border mb-40 pb-35">
                            <div class="sidebar-widget-title mb-25">
                                <h3>Product Categories</h3>
                            </div>
                            <div class="sidebar-list-style">
                                <div class="categories-select">
                                    @if ($selected_category == 'all' || $selected_category == null)
                                        <div class="category-selected" data-category-id="all">All</div>
                                    @else
                                        @foreach ($categories as $category)
                                            @if ($selected_category == $category->category_id)
                                                <div class="category-selected"
                                                    data-category-id="{{ $selected_category }}">
                                                    {{ $category->name }}</div>
                                            @endif
                                        @endforeach
                                    @endif

                                    <div class="categories-options">
                                        <div class="option" data-category-id="all">All</div>

                                        @foreach ($categories as $category)
                                            <div class="option" data-category-id="{{ $category->category_id }}">
                                                {{ $category->name }}
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget sidebar-widget-border mb-40 pb-35" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="sidebar-widget-title mb-25">
                                <h3>Choose Colour</h3>
                            </div>
                            <div class="sidebar-widget-color sidebar-list-style">
                                <div class="row g-2">
                                    @foreach ($colors as $color)
                                        <div class="col-auto">
                                            <label class="form-colorinput form-colorinput-light">
                                                <input name="color" type="checkbox" value=""
                                                    class="form-colorinput-input" data-id="{{ $color->color_id }}"
                                                    @if (in_array($color->color_id, $selected_colors)) @checked(true) @endif />
                                                <span class="form-colorinput-color "
                                                    style="background-color: {{ $color->code }}"></span>
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="sidebar-widget" data-aos="fade-up" data-aos-delay="200">
                            <div class="sidebar-widget-title mb-25">
                                <h3>Tags</h3>
                            </div>
                            <div class="sidebar-widget-tag">
                                <div class="row g-2">
                                    @foreach ($tags as $tag)
                                        <div class="col-auto">
                                            <label class="form-taginput form-taginput-light">
                                                <input name="color" type="checkbox" value="white"
                                                    class="form-taginput-input" data-id="{{ $tag->tag_id }}"
                                                    @if (in_array($tag->tag_id, $selected_tags)) @checked(true) @endif />
                                                <span class="form-taginput-tag">#{{ $tag->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
