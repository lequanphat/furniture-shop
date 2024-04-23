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
                        Warranty Details
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="/admin/warranties" class="btn">
                                Back
                            </a>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="page-body mb-2">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <!--khung warranty-->
                <div class="col-md-4 markdown">
                    <div class="card">
                        <div class="card-body">
                            <h3>Warranty Info</h3>
                            <address>
                                <strong>Warranty ID: </strong><span id="" class="m-0">{{ $warranty->warranty_id }}</span><br>
                                <strong>Start date: </strong>{{ $warranty->start_date }}<br>
                                <strong>End date: </strong>{{ $warranty->end_date }}<br>
                                <strong>Warranty Period: </strong>{{ $warranty->product_detail->warranty_month }}<br>
                                <strong>Status: </strong>
                                @if ($warranty->is_active())
                                    <span class="badge bg-green-lt">Still on</span>
                                @else
                                    <span class="badge bg-red-lt">Not Within</span>
                                @endif <br>
                                <strong>Description: </strong>{{ $warranty->description }}<br>
                            </address>
                        </div>
                    </div>
                </div>
                <!--Khung order-->
                <div class="col-md-4 markdown">
                    <div class="card">
                        <div class="card-body">
                            <h3>Order Infor</h3>
                            <address>
                                <strong>Order ID: </strong><span id="" class="m-0">{{ $warranty->order->order_id }}</span><br>
                                <strong>Status: </strong>{{ $warranty->order->get_status() }}<br>
                                <strong>Paid: </strong>{{ $warranty->order->get_is_paid() }}<br>
                                <strong>Total price:</strong>
                                <span
                                    class="text-success">{{ number_format(
                                        $detailed_orders->sum(function ($detailed_order) {
                                            return $detailed_order->unit_price * $detailed_order->quantities;
                                        }),
                                        0,
                                        '.',
                                        ',',
                                    ) }}đ
                                </span><br>
                                <strong>Number of products: </strong>{{ $detailed_orders->count() }}
                            </address>
                        </div>
                    </div>
                </div>
                <!--Khung product-->
                <div class="col-md-4 markdown">
                    <div class="card">
                        <div class="card-body">
                            <h3>Product Info</h3>
                            <address>
                                <strong>Product ID: </strong><span id="" class="m-0">{{ $warranty->product_detail->product_id }}</span><br>
                                <strong>Product detail ID: </strong> {{ $warranty->sku }} <br>
                                <strong>Name: </strong> {{ $warranty->product_detail->name }} <br>
                                <strong>Description: </strong> {{ $warranty->product_detail->description }} <br>
                            </address>
                        </div>
                    </div>
                </div>
                <!--Khung customer-->
                <div class="col-md-4 markdown">
                    <div class="card">
                        <div class="card-body">
                            <h3>Customer Info</h3>
                            <address>
                                <strong>Name: </strong> {{ $warranty->order->receiver_name }} <br>
                                <strong>Address: </strong>{{ $warranty->order->address }}<br>
                                <strong>Phone number: </strong>{{ $warranty->order->phone_number }}<br>
                                @isset($warranty->order->customer->email)
                                    <strong>Email: </strong><a href="mailto:{{ $warranty->order->customer->email }}">{{ $warranty->order->customer->email }}</a>
                                @endisset
                            </address>
                        </div>
                    </div>
                </div>
                <!--khung nhân viên tạo đơn này-->
                @if (isset($warranty->order->employee))
                    <div class="col-md-4 markdown">
                        <div class="card">
                            <div class="card-body">
                                <h3>Created by</h3>
                                <address>
                                    <strong>Name: </strong> {{ $warranty->order->employee->full_name() }}<br>
                                    @if (isset($warranty->order->employee->default_addres))
                                        <strong>Address: </strong>{{ $warranty->order->employee->default_address->address }}<br>
                                        <strong>Phone number: </strong>{{ $warranty->order->employee->default_address->phone_number }}<br>
                                    @endif
                                    <strong>Email: </strong><a href="mailto:#">{{ $warranty->order->employee->email }}</a>
                                </address>
                            </div>
                        </div>
                    </div>
                @endif



            </div>
        </div>
    </div>


    @include('admin.components.footer')
@endsection
