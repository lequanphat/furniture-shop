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
                        Details List
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="{{ route('products.index') }}" class="btn">Back</a>
                        </span>
                        <a href="{{ route('products.create_product_details_ui', $product->product_id) }}"
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
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="js-user-table table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Warranty month</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detaild_products as $detaild_product)
                                        <tr>
                                            <td>{{ $detaild_product->name }}</td>
                                            <td>{{ $detaild_product->sku }}</td>
                                            <td>{{ number_format($detaild_product->original_price, 0, '.', ',') }}đ</td>
                                            <td>
                                                <div class="col-auto rounded"
                                                    style="background: {{ $detaild_product->color }}; width: 20px; height: 20px;">
                                                </div>
                                            </td>
                                            <td>{{ $detaild_product->size }}</td>
                                            <td>{{ $detaild_product->warranty_month }}</td>
                                            <td><a href="#" class="btn p-2">
                                                    <img src="{{ asset('svg/view.svg') }}" style="width: 18px;" />
                                                </a>
                                                <a href="#" class="btn p-2">
                                                    <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                </a>
                                                <a href="#" class="btn p-2">
                                                    <img src="{{ asset('svg/trash.svg') }}" style="width: 18px;" />
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
