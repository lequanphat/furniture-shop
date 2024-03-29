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
                        <a href="#"
                            class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Add new product
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

                    <form id="create-order-form" action="#" method="POST" class="card">
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="order_id" class="form-label">Order Number</label>
                                        <input id="order_id" name="order_id" type="text" class="form-control"
                                            value="{{ $order->order_id }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="receiver_name" class="form-label">Receiver name</label>
                                        <input id="receiver_name" name="receiver_name" type="text" class="form-control"
                                            value="{{ $order->receiver_name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="create_at" class="form-label">Day create</label>
                                        <input id="create_at" name="create_at" type="text" class="form-control"
                                            value="{{ $order->created_at }}" readonly>
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
                                            <th>Product details</th>
                                            <th>Quantities</th>
                                            <th>Unit price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detail_orders as $detail_order)
                                        <tr>
                                            <td>{{ $detail_order->sku }}</td>
                                            <td>{{ $detail_order->quantities }}</td>
                                            <td>{{ $detail_order->unit_price }}</td>
                                        </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end my-2">
                                    {{ $detail_orders->render('common.pagination') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.components.footer')
        </div>
        {{-- Modal --}}
    @endsection
