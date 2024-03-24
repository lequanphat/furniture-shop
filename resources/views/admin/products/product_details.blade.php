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
                        Product Details
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="{{ route('products.index') }}" class="btn">
                                Back
                            </a>
                        </span>
                        <a href="{{ route('products.create_detailed_product_ui', $product->product_id) }}"
                            class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new instance
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body mb-2">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <form id="create-product-form" action="#" method="POST" class="card">
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Product Title</label>
                                        <input id="title" name="title" type="text" class="form-control"
                                            value="{{ $product->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Brand</label>
                                        <input id="brand" name="brand" type="text" class="form-control"
                                            value="{{ $product->brand->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <input id="category" name="category" type="text" class="form-control"
                                            value="{{ $product->category->name }}" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="page-body mt-2">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="js-user-table table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantities</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Warranty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detaild_products as $detaild_product)
                                            <tr>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url(@if (isset($detaild_product->images->first()->url)) {{ asset('storage/' . $detaild_product->images->first()->url) }} @endif); width: 80px; height: 80px;">
                                                        </span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">
                                                                <h3 class="m-0">{{ $detaild_product->name }}
                                                                    @if ($detaild_product->created_at->diffInDays() < 7)
                                                                        <span
                                                                            class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                                        </span>
                                                                    @endif
                                                                </h3>
                                                            </div>
                                                            <div class="text-muted">
                                                                <a href="#"
                                                                    class="text-reset">#{{ $detaild_product->sku }}</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>{{ number_format($detaild_product->original_price, 0, '.', ',') }}đ</td>
                                                <td>{{ $detaild_product->quantities }}</td>
                                                <td>
                                                    <div class="col-auto rounded"
                                                        style="background: {{ $detaild_product->color }}; width: 20px; height: 20px;">
                                                    </div>
                                                </td>
                                                <td>{{ $detaild_product->size }}</td>
                                                <td>{{ $detaild_product->warranty_month }} Months</td>
                                                <td><a href="{{ route('products.detailed_product_details', ['product_id' => $product->product_id, 'sku' => $detaild_product->sku]) }}"
                                                        class="btn p-2">
                                                        <img src="{{ asset('svg/view.svg') }}" style="width: 18px;" />
                                                    </a>
                                                    <a href="{{ route('products.update_detailed_product_ui', ['product_id' => $product->product_id, 'sku' => $detaild_product->sku]) }}"
                                                        class="btn p-2">
                                                        <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end my-2">
                                    {{ $detaild_products->render('common.pagination') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.components.footer')
        </div>
        {{-- Modal --}}
    @endsection
