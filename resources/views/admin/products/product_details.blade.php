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
                        @can('create product')
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
                        @endcan
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
                                <div class="col-12">
                                    <div class="badges-list">
                                        <span class="">Tag: </span>
                                        @foreach ($product->product_tags as $product_tag)
                                            <span class="badge bg-cyan-lt">#{{ $product_tag->tag->name }}</span>
                                        @endforeach
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
                                            <th>Color & Size</th>
                                            <th>Warranty</th>
                                            <th>Quantities</th>
                                            <th>Dicounts</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detaild_products as $detailed_product)
                                            <tr>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url(@if (isset($detailed_product->images->first()->url)) {{ $detailed_product->images->first()->url }} @endif); width: 80px; height: 80px; flex-shrink: 0;">
                                                        </span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">
                                                                <h3 class="m-0">{{ $detailed_product->name }}
                                                                    @if ($detailed_product->created_at->diffInDays() < 7)
                                                                        <span
                                                                            class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                                        </span>
                                                                    @endif
                                                                </h3>
                                                            </div>
                                                            <div class="text-muted">
                                                                <a href="#"
                                                                    class="text-reset">#{{ $detailed_product->sku }}</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>
                                                    <p class="m-0">Color: {{ $detailed_product->color->name }}</p>
                                                    <p class="my-1">Size: {{ $detailed_product->size }}</p>
                                                </td>
                                                <td>{{ $detailed_product->warranty_month }} Months</td>
                                                <td>{{ $detailed_product->quantities }}</td>
                                                <td>
                                                    @if (isset($detailed_product->product_discounts->first()->discount))
                                                        @foreach ($detailed_product->product_discounts as $product_discount)
                                                            <span
                                                                class="badge bg-cyan-lt">{{ $product_discount->discount->percentage }}%</span>
                                                        @endforeach
                                                    @else
                                                        <span class="badge bg-cyan-lt">No discount</span>
                                                    @endif


                                                </td>
                                                <td>
                                                    @if ($detailed_product->product_discounts->sum('discount.percentage') > 0)
                                                        <del
                                                            class="text-muted">{{ number_format($detailed_product->original_price - ($detailed_product->original_price * $detailed_product->product_discounts->sum('discount.percentage')) / 100, 0, '.', ',') }}đ</del>
                                                    @endif

                                                    <p class="text-danger m-0">
                                                        {{ number_format($detailed_product->original_price, 0, '.', ',') }}đ
                                                    </p>
                                                </td>

                                                </td>

                                                <td><a href="{{ route('products.detailed_product_details', ['product_id' => $product->product_id, 'sku' => $detailed_product->sku]) }}"
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
                                                        <a href="{{ route('products.update_detailed_product_ui', ['product_id' => $product->product_id, 'sku' => $detailed_product->sku]) }}"
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
                                                            data-bs-target="#delete-detailed-product-modal">
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
        <div class="modal modal-blur fade" id="delete-detailed-product-modal" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-title">Are you sure?</div>
                        <div class="js-message">If deleted, this product will no longer be visible to users.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary me-auto"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="js-delete btn btn-danger" data-bs-dismiss="modal">Yes, delete this
                            product</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal --}}

        {{-- Script --}}
        <script src="{{ asset('js/product_api.js') }}" defer></script>
    @endsection
