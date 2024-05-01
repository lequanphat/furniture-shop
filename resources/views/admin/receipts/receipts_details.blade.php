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
                        Receipt Details
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="/admin/receipts" class="btn">
                                Back
                            </a>
                        </span>
                        @can('create receipt')
                            <a class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#create-detailed-receipt-modal"
                                data-order-id="{{ $receipt->receiving_report_id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Add product

                            </a>
                            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                                data-bs-target="#create-detailed-receipt-modal" aria-label="Create new report">
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
                <div class="col-md-4 markdown">
                    <div class="card">
                        <div class="card-body">
                            <h3>Receipt Infor</h3>
                            <address>
                                <strong>ID: </strong><span id="js-receipt-id-info"
                                    class="m-0">{{ $receipt->receiving_report_id }}</span><br>
                                <strong>Total price: </strong>
                                <span
                                    class="text-success">{{ number_format(
                                        $detailed_receipts->sum(function ($detailed_receipt) {
                                            return $detailed_receipt->unit_price * $detailed_receipt->quantities;
                                        }),
                                        0,
                                        '.',
                                        ',',
                                    ) }}đ
                                </span><br>
                                <strong>Number of products: </strong>{{ $detailed_receipts->count() }}
                            </address>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 markdown">
                    <div class="card">
                        <div class="card-body">
                            <h3>Supplier Infor</h3>
                            <address><strong>{{ $receipt->supplier->name }} <br>
                                </strong>{{ $receipt->supplier->address }}<br>
                                {{ $receipt->supplier->phone_number }}<br>

                            </address>
                        </div>
                    </div>
                </div>
                @if (isset($receipt->employee))
                    <div class="col-md-4 markdown">
                        <div class="card">
                            <div class="card-body">
                                <h3>Created by</h3>
                                <address>
                                    <strong>{{ $receipt->employee->full_name() }}<br></strong>
                                    @if (isset($receipt->employee->default_addres))
                                        {{ $receipt->employee->default_address->address }}<br>
                                        {{ $receipt->employee->default_address->phone_number }}<br>
                                    @endif


                                    <a href="mailto:#">{{ $receipt->employee->email }}</a>
                                </address>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="page-body mt-2">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Color & Size</th>
                                            <th>Unit Price</th>
                                            <th>Quantities</th>
                                            <th>Warranty</th>
                                            <th>Total price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailed-receipt-table">
                                        @foreach ($detailed_receipts as $detailed_receipt)
                                            <tr>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url(@if (isset($detailed_receipt->detailed_product->images->first()->url)) {{ $detailed_receipt->detailed_product->images->first()->url }} @endif); width: 80px; height: 80px;">
                                                        </span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">
                                                                <h3 class="m-0">
                                                                    {{ $detailed_receipt->detailed_product->name }}
                                                                    @if ($detailed_receipt->detailed_product->created_at->diffInDays() < 7)
                                                                        <span
                                                                            class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                                        </span>
                                                                    @endif
                                                                </h3>
                                                            </div>
                                                            <div class="text-muted">
                                                                <a href="#"
                                                                    class="text-reset js-sku">#{{ $detailed_receipt->detailed_product->sku }}</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>
                                                    <p class="m-0">Color:
                                                        {{ $detailed_receipt->detailed_product->color->name }}</p>
                                                    <p class="my-1">Size: {{ $detailed_receipt->detailed_product->size }}
                                                    </p>
                                                </td>
                                                <td class="text-danger">{{ number_format($detailed_receipt->unit_price) }}đ
                                                </td>
                                                <td>{{ $detailed_receipt->quantities }}</td>
                                                <td>{{ $detailed_receipt->detailed_product->warranty_month }} Months</td>
                                                <td class="text-success">
                                                    {{ number_format($detailed_receipt->unit_price * $detailed_receipt->quantities, 0, '.', ',') }}đ
                                                <td>
                                                    @can('delete receipt')
                                                        <a href="#" class="btn p-2"
                                                            data-sku="{{ $detailed_receipt->detailed_product->sku }}"
                                                            data-receipt-id="{{ $detailed_receipt->receiving_report_id }}"
                                                            data-name="{{ $detailed_receipt->detailed_product->name }}"
                                                            data-bs-toggle="modal" data-bs-target="#delete-confirm-modal">
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
                                    {{ $detailed_receipts->render('common.pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.components.footer')
        </div>
        {{-- Modal --}}
        @include('admin.receipts.create_detailed_receipt')
        @include('admin.components.delete_confirm_modal')
        {{-- Script --}}
        <script src="{{ asset('js/receipts_api.js') }}" defer></script>
    @endsection
