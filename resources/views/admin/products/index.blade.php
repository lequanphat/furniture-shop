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

                    <div class="row justify-content-end">

                        <div class="col-3">
                            <div class="input-icon ">
                                <input id="search-product-input" type="text" value="{{ $search }}"
                                    class="form-control" placeholder="Search…">
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
                        </div>


                        <div class="col-3">
                            <select id="categories_select" name="type" class="form-select" title="Choose type">
                                <option value="all" @if ($selected_category == 'all') selected @endif>All Categories
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                        @if ($selected_category == $category->category_id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-2">
                            <select id="brands_select" name="type" class="form-select" title="Choose type">
                                <option value="all" @if ($selected_brand == 'all') selected @endif>All Brands</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->brand_id }}"
                                        @if ($selected_brand == $brand->brand_id) selected @endif>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @can('create product')
                            <div class="col-auto">
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
                                <a href="{{ route('products.create') }}" class="btn btn-primary d-sm-none btn-icon"
                                    aria-label="Create new report">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                </a>
                            </div>
                        @endcan

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
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Average Price</th>
                                        <th>Quantities</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="product-table-body">
                                    @if ($products->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->product_id }}</td>
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

                                                <td class="text-danger">
                                                    {{ number_format($product->detailed_products->avg('original_price'), 0, '.', ',') }}đ
                                                </td>
                                                <td>{{ $product->detailed_products->sum('quantities') }}</td>

                                                <td>{{ $product->brand->name }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                <td>

                                                    <a href="{{ route('products.details', $product->product_id) }}"
                                                        class="btn p-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path
                                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                        </svg>
                                                    </a>
                                                    @can('update product')
                                                        <a href="{{ route('products.update_ui', $product->product_id) }}"
                                                            class="btn p-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                                <path d="M13.5 6.5l4 4" />
                                                            </svg>
                                                        </a>
                                                    @endcan

                                                    @can('delete product')
                                                        <a class="btn p-2" data-bs-toggle="modal"
                                                            data-bs-target="#delete-product-modal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

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
    @include('admin.products.delete_confirm_modal')
    {{-- Script --}}
    <script src="{{ asset('js/product_api.js') }}" defer></script>
@endsection
