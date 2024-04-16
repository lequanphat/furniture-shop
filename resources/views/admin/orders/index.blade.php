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
                        {{ $page }} Management
                    </h2>
                </div>

                <!-- Page actions -->

                {{-- Sắp xếp theo order đc tạo gần nhất --}}
                <div class="col-sm-6 col-md-2 ">
                    <label class="form-check form-check-inline">
                        <input id="sort_by_last" name="sort_by_last" class="form-check-input" type="checkbox">
                        <span class="form-check-label">Recent created</span>
                    </label>
                </div>

                {{-- Lấy order trong 1 khoảng thời gian --}}
                <div class="col-sm-6 col-md-2 ">
                    <label for="search_in_period" class="form-label">Peiod of time</label>
                    <div class="btn-list" name="search_in_period">
                        <input id="day_first" name="day_first" class="form-control" type="date">
                        <input id="day_last" name="day_last" class="form-control" type="date">
                    </div>
                </div>


                <div class="col-auto ms-auto d-print-none">


                    <div class="btn-list">
                        {{-- ô search và cái icon của nó --}}
                        <div class="input-icon ">
                            <input id="search-orders" name="search" type="text" value=""
                                class="form-control" placeholder="Search by ID..." autocomplete="off">

                        </div>
                        {{-- tạo order mới --}}
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#order-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new order
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
                                        <th>Order information</th>
                                        <th>Date time</th>
                                        <th>Total Price</th>
                                        <th>Paid</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id ="order-table">

                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_id }}</td>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium">
                                                            {{ $order->receiver_name . ' - ' . $order->phone_number }}
                                                            @if ($order->created_at->diffInDays() < 7)
                                                                <span
                                                                    class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                                            @endif
                                                        </div>
                                                        <div class="text-muted"><a href="#"
                                                                class="text-reset">{{ $order->address }}</a></div>
                                                    </div>
                                                </div>
                                            </td>


                                            <td><span>{{ Carbon::parse($order->created_at)->diffForHumans() }}</span></td>
                                            <td>{{ number_format($order->total_price, 0, '.', ',') }}đ</td>
                                            <td>
                                                @switch($order->is_paid)
                                                    @case(0)
                                                        <span class="badge bg-yellow-lt">Pending Payment</span>
                                                    @break

                                                    @case(1)
                                                        <span class="badge bg-green-lt">Payment Received</span>
                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($order->status)
                                                    @case(0)
                                                        <span class="badge bg-yellow-lt">Unconfirmed</span>
                                                    @break

                                                    @case(1)
                                                        <span class="badge bg-azure-lt">Confirmed</span>
                                                    @break

                                                    @case(2)
                                                        <span class="badge bg-purple-lt">In transit</span>
                                                    @break

                                                    @case(3)
                                                        <span class="badge bg-green-lt">Delivered</span>
                                                    @break

                                                    @case(4)
                                                        <span class="badge bg-red-lt">Canceled</span>
                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.details', $order->order_id) }}" class="btn p-2"
                                                    title="Details">
                                                    <img src="{{ asset('svg/view.svg') }}" style="width: 18px;" />
                                                </a>
                                                <button type="button" class="js-update-order-btn btn  mr-2 px-2 py-2"
                                                    title="Update" data-bs-toggle="modal"
                                                    data-bs-target="#update-order-modal"
                                                    data-order-id="{{ $order->order_id }}"
                                                    data-total-price="{{ $order->total_price }}"
                                                    data-is-paid="{{ $order->is_paid }}"
                                                    data-status="{{ $order->status }}"
                                                    data-receiver-name="{{ $order->receiver_name }}"
                                                    data-address="{{ $order->address }}"
                                                    data-phone-number="{{ $order->phone_number }}"
                                                    data-customer-id="{{ $order->customer_id }}"
                                                    data-created-by="{{ $order->created_by }}">
                                                    <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end my-2">{{ $orders->render('common.ajax-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @include('admin.components.footer')
    </div>
    {{-- Modal --}}
    @include('admin.orders.create_order_modal')
    @include('admin.orders.update_order_modal')
   {{-- Script --}}
   <script src="{{ asset('js/order_api.js') }}" defer></script>
@endsection
