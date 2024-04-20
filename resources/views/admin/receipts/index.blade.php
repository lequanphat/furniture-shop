@extends('layouts.admin')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Receipts Management
                    </h2>
                </div>

                <!-- Page actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        {{-- ô search và cái icon của nó --}}
                        <div class="input-icon ">
                            <input id="search-orders" name="search" type="text" value="" class="form-control"
                                   placeholder="Search…" autocomplete="off">

                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </span>
                        </div>
                        {{-- tạo order mới --}}
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                           data-bs-target="#receipts-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new Receipts
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
                                    <th>#</th>
                                    <th>Receiving Report Id</th>
                                    <th>Total Price</th>
                                    <th>Supplier Id</th>
                                    <th>created By</th>
                                    <th>Created At</th>
                                    <th>Update At</th>
                                </tr>
                                </thead>
                                <tbody id="receipts-table">

                                @foreach ($receipts as $receiving)
                                    <tr>
                                        <td>{{ $receiving->receiving_report_id }}</td>
                                        <td>
                                            <div class="d-flex py-1 align-items-center">
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium">

                                                        @if ($receiving->created_at->diffInDays() < 7)
                                                            <span
                                                                class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </td>


                                        <td>{{ number_format($receiving->total_price, 0, '.', ',') }}đ


                                        </td>
                                        <td>
                                            {{$receiving->supplier_id}}
                                        </td>

                                        <td>
                                            {{ $receiving->created_by }}
                                        </td>
                                        <td>
                                            {{$receiving->created_at}}
                                        </td>
                                        <td>
                                            {{$receiving->update_at}}
                                        </td>
                                        <td>
                                            {{--                                            <a href="{{ route('orders.details', $order->order_id) }}" class="btn p-2"--}}
                                            {{--                                               title="Details">--}}
                                            {{--                                                <img src="{{ asset('svg/view.svg') }}" style="width: 18px;" />--}}
                                            {{--                                            </a>--}}
                                            {{--                                            <button type="button" class="js-update-order-btn btn  mr-2 px-2 py-2"--}}
                                            {{--                                                    title="Update" data-bs-toggle="modal"--}}
                                            {{--                                                    data-bs-target="#update-order-modal"--}}
                                            {{--                                                    data-order-id="{{ $order->order_id }}"--}}
                                            {{--                                                    data-total-price="{{ $order->total_price }}"--}}
                                            {{--                                                    data-is-paid="{{ $order->is_paid }}"--}}
                                            {{--                                                    data-status="{{ $order->status }}"--}}
                                            {{--                                                    data-receiver-name="{{ $order->receiver_name }}"--}}
                                            {{--                                                    data-address="{{ $order->address }}"--}}
                                            {{--                                                    data-phone-number="{{ $order->phone_number }}"--}}
                                            {{--                                                    data-customer-id="{{ $order->customer_id }}"--}}
                                            {{--                                                    data-created-by="{{ $order->created_by }}">--}}
                                            {{--                                                <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />--}}
                                            {{--                                            </button>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--                            <div class="d-flex justify-content-end my-2">{{ $orders->render('common.ajax-pagination') }}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('admin.components.footer')
    </div>
    {{-- Modal --}}
    @include('admin.receipts.ReceiptsCreate')
    {{-- Script --}}
    <script src="{{ asset('js/order_api.js') }}" defer></script>
@endsection
