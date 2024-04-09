@extends('layouts.admin')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Products Management
                    </h2>
                </div>
                <!-- Page actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <div class="input-icon ">
                            <input id="search-product-input" type="text" value="{{ $search }}" class="form-control"
                                placeholder="Search…">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </span>
                        </div>
                        <a href="{{ route('products.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new product
                        </a>
                    </div>
                </div>
                <!-- End Page actions -->
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Average Price</th>
                                        <th>Quantities</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="product-table-body">
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    @php
                                                        $imageUrl = null;
                                                        foreach ($product->detailed_products as $detailed_product) {
                                                            if ($image = $detailed_product->images->first()) {
                                                                $imageUrl = $image->url;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    <span class="avatar me-2"
                                                        style="background-image: url({{ $imageUrl }}); width: 80px; height: 80px; flex-shrink: 0;"></span>
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium">
                                                            <h3 class="m-0">{{ $product->name }}
                                                                @if ($product->created_at->diffInDays() < 7)
                                                                    <span
                                                                        class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                                    </span>
                                                                @endif
                                                            </h3>
                                                        </div>
                                                        <div class="text-muted">
                                                            <a href="{{ route('products.details', $product->product_id) }}"
                                                                class="text-reset">{{ $product->detailed_products->count() }}
                                                                detailed products</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ number_format($product->detailed_products->avg('original_price'), 0, '.', ',') }}đ
                                            </td>
                                            <td>{{ $product->detailed_products->sum('quantities') }}</td>

                                            <td>{{ $product->brand->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>
                                                <a href="{{ route('products.details', $product->product_id) }}"
                                                    class="btn p-2">
                                                    <img src="{{ asset('svg/view.svg') }}" style="width: 18px;" />
                                                </a>
                                                <a href="{{ route('products.update_ui', $product->product_id) }}"
                                                    class="btn p-2">
                                                    <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end my-2">{{ $products->render('common.ajax-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.components.footer')
    </div>
    {{-- Modal --}}

    {{-- Script --}}
    <script src="{{ asset('js/product_api.js') }}" defer></script>
@endsection
