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
                        Discount Details @if ($discount->is_active === 0)
                            <span class="badge bg-red-lt">Blocked</span>
                        @else
                            <span class="badge bg-green-lt">Active</span>
                        @endif
                    </h2>




                </div>
                <!-- Page title actions -->


                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="/admin/discounts" class="btn">
                                Back
                            </a>
                        </span>
                        @can('create discount')
                            <a class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#add-product-to-discount-modal" data-order-id="{{ $discount->discount_id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Add product
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#add-product-to-discount-modal"
                                class="btn btn-primary d-sm-none btn-icon" aria-label="Create new report">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
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
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="title" class="form-label"> ID</label>
                                        <input id="discount_id" name="discount_id" type="text" class="form-control"
                                            placeholder="" value="{{ $discount->discount_id }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="title" class="form-label"> Title</label>
                                        <input id="title" name="title" type="text" class="form-control"
                                            placeholder="" value="{{ $discount->title }}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Percentage</label>
                                        <input class="form-control" type="number" id="percentage" name="percentage"
                                            min="0" max="100 " value="{{ $discount->percentage }}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start date</label>

                                        <input class="form-control" type="date" id="startdate" name="startdate"
                                            value="{{ $discount->start_date }}" readonly>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">End date</label>

                                        <input class="form-control" type="date" id="enddate" name="enddate"
                                            value="{{ $discount->end_date }}" readonly>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="page-body mt-2">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive ">
                                <form id="update-discount-product-form" action="#" method="POST">
                                    @csrf
                                    <table class="js-user-table table table-vcenter card-table ">
                                        <thead style="position: sticky; top: 0; z-index: 1; background-color: #fff;">
                                            <tr>
                                                <th>Name</th>
                                                <th>Color & Size</th>
                                                <th>Quantities</th>
                                                <th>Unit price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail_discount_table">
                                            @foreach ($products as $detailed_product)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex py-1 align-items-center">
                                                            <span class="avatar me-2"
                                                                style="background-image: url(@if (isset($detailed_product->images->first()->url)) {{ $detailed_product->images->first()->url }} @endif); width: 80px; height: 80px; flex-shrink: 0;">
                                                            </span>
                                                            <div class="flex-fill">
                                                                <div class="font-weight-medium">
                                                                    <h3 class="m-0">
                                                                        {{ $detailed_product->name }}
                                                                        @if ($detailed_product->created_at->diffInDays() < 7)
                                                                            <span
                                                                                class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                                            </span>
                                                                        @endif
                                                                    </h3>
                                                                </div>
                                                                <div class="text-muted">
                                                                    <a href="#"
                                                                        class="text-reset js-sku">#{{ $detailed_product->sku }}</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="m-0">Color:
                                                            {{ $detailed_product->color->name }}
                                                        </p>
                                                        <p class="my-1">Size:
                                                            {{ $detailed_product->size }}</p>
                                                    </td>
                                                    <td>{{ $detailed_product->quantities }}</td>
                                                    <td class="text-danger">
                                                        {{ number_format($detailed_product->original_price, 0, '.', ',') }}đ
                                                    </td>
                                                    <td>
                                                        @can('delete discount')
                                                            <a href="#" class="btn p-2"
                                                                data-sku="{{ $detailed_product->sku }}"
                                                                data-discount-id="{{ $discount->discount_id }}"
                                                                data-name="{{ $detailed_product->name }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete-product-confirm-modal">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
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
                                        {{ $products->render('common.pagination') }}</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin.components.footer')


            </div>
        </div>
        {{-- Modal --}}
        @include('admin.components.delete_confirm_modal')

        @include('admin.discounts.add_product_to_discount_modal')

        @include('admin.discounts.remove-product-from-discount')
        {{-- Script --}}
        <script src="{{ asset('js/discount_api.js') }}" defer></script>
    @endsection
