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
                    Order Details
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <span class="d-none d-sm-inline">
                        <a href="/admin/orders" class="btn">
                            Back
                        </a>
                    </span>
                    <a class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#create-detailed-order-modal" data-order-id="{{ $receipt->receiving_report_id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add product
                    </a>
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
                        <h3>Order Infor</h3>
                        <address>
                            <strong>ID: </strong><span id="js-order-id-info" class="m-0">{{ $receipt->receiving_report_id }}</span><br>
                            <!-- <strong>Total Price: </strong>{{ $receipt->total_price }}<br> -->
                            <strong>Supplier-Id: </strong>{{ $receipt->supplier_id }}<br>
                            <strong>Total price:
                            </strong>
                            <span class="text-success">{{ number_format(
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
                        <h3>Customer Infor</h3>
                        <address><strong>{{ $receipt->created_by}} <br>
                            </strong>{{ $receipt->customer->email }}<br>
                            {{ $receipt->customer->first_name }}<br>

                            {{ $receipt->customer->last_name }}<br>
                            @isset($receipt->customer->email)
                            <a href="mailto:{{ $receipt->customer->email}}">{{ $receipt->customer->email}}</a>
                            @endisset
                        </address>
                    </div>
                </div>

            </div>
            <!-- @if (isset($order->employee))
            <div class="col-md-4 markdown">
                <div class="card">
                    <div class="card-body">
                        <h3>Created by</h3>
                        <address>
                            <strong>{{ $order->employee->full_name() }}<br></strong>
                            @if (isset($order->employee->default_addres))
                            {{ $order->employee->default_address->address }}<br>
                            {{ $order->employee->default_address->phone_number }}<br>
                            @endif


                            <a href="mailto:#">{{ $order->employee->email }}</a>
                        </address>
                    </div>
                </div>
            </div>
            @endif -->

            <!-- @if (isset($order->note))
            <div class="col-md-4 markdown">
                <div class="card">
                    <div class="card-body">
                        <h3>Order note</h3>
                        <address>
                            {{ $order->note }}
                        </address>
                    </div>
                </div>
            </div> -->
            <!-- @endif -->
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
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Unit Price</th>
                                        <th>Quantities</th>
                                        <th>Warranty</th>
                                        <th>Total price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <!-- <tbody>
                                    @foreach ($detailed_orders as $detailed_order)
                                    <tr>
                                        <td>
                                            <div class="d-flex py-1 align-items-center">
                                                <span class="avatar me-2" style="background-image: url(@if (isset($detailed_order->detailed_product->images->first()->url)) {{ $detailed_order->detailed_product->images->first()->url }} @endif); width: 80px; height: 80px;">
                                                </span>
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium">
                                                        <h3 class="m-0">
                                                            {{ $detailed_order->detailed_product->name }}
                                                            @if ($detailed_order->detailed_product->created_at->diffInDays() < 7) <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                                </span>
                                                                @endif
                                                        </h3>
                                                    </div>
                                                    <div class="text-muted">
                                                        <a href="#" class="text-reset">#{{ $detailed_order->detailed_product->sku }}</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="col-auto rounded" style="background: {{ $detailed_order->detailed_product->color->code }}; width: 20px; height: 20px;">
                                            </div>
                                        </td>
                                        <td>{{ $detailed_order->detailed_product->size }}</td>
                                        <td>{{ number_format($detailed_order->unit_price) }}đ
                                        </td>
                                        <td>{{ $detailed_order->quantities }}</td>
                                        <td>{{ $detailed_order->detailed_product->warranty_month }} Months</td>
                                        <td class="text-success">
                                            {{ number_format($detailed_order->unit_price * $detailed_order->quantities, 0, '.', ',') }}đ
                                        <td>
                                            <!--nút sửa, order detail chỉ nên ửa được quantity-->
                                            <button type="button" class="js-update-order-btn btn  mr-2 px-2 py-1" title="Update" data-bs-toggle="modal" data-bs-target="#UpdateOrderDetailModal" data-order-id="{{ $order->order_id }}" data-product-detail-id="{{ $detailed_order->detailed_product->sku }}" data-quantities="{{ $detailed_order->quantities }}" data-unit-price="{{ $detailed_order->unit_price }}">
                                                <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody> -->
                            </table>
                            <div class="d-flex justify-content-end my-2">
                                {{ $detailed_orders->render('common.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.components.footer')
    </div>
    {{-- Modal --}}
    @include('admin.orders.create_detailed_order')
    {{-- Script --}}
    <script src="{{ asset('js/order_api.js') }}" defer></script>
    @endsection