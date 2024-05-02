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
                <div class="col-auto ms-auto d-print-none">
                    <div class="row justify-content-end">
                        <div class="col-3">
                            <div class="input-icon ">
                                <input id="search-orders" name="search" type="text" class="form-control"
                                    placeholder="Search…" autocomplete="off" value="{{ $search }}">
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
                        </div>

                        <div class="col-4 row ">
                            <div class="col-6">
                                <input id="day_first" name="day_first" class="col-6 form-control" type="date"
                                    value="{{ $dayfirst }}" title="Start date">
                            </div>
                            <div class="col-6">
                                <input id="day_last" name="day_last" class="col-6 form-control" type="date"
                                    value="{{ $daylast }}" title="End date">
                            </div>

                        </div>

                        <div class="col-2">
                            <select id="type" name="type" class="form-select" title="Choose type">
                                <option value="all" @if ($type == 'all') selected @endif>All</option>
                                <option value="0" @if ($type == '0') selected @endif>Unconfirm</option>
                                <option value="1" @if ($type == '1') selected @endif>Confirmed</option>
                                <option value="2" @if ($type == '2') selected @endif>In transit</option>
                                <option value="3" @if ($type == '3') selected @endif>Delivered</option>
                                <option value="4" @if ($type == '4') selected @endif>Canceled</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select id="sort_by_last" name="sort_by_last" class="form-select" title="Sort">
                                <option value="latest" @if ($sort == 'latest') selected @endif>Latest Orders
                                </option>
                                <option value="oldest" @if ($sort == 'oldest') selected @endif>Oldest Orders
                                </option>
                                <option value="price_asc" @if ($sort == 'price_asc') selected @endif>Price ascending
                                </option>
                                <option value="price_desc" @if ($sort == 'price_desc') selected @endif>Price
                                    descending</option>
                            </select>
                        </div>
                        @can('create order')
                            <div class="col-auto">
                                <a href="#" class="btn btn-primary w-100 btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#order-modal" title="Create new order">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon " width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                </a>
                            </div>
                        @endcan

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
                                    @if ($orders->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
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


                                                <td class="text-muted">
                                                    <span>{{ Carbon::parse($order->created_at)->diffForHumans() }}</span>
                                                </td>
                                                <td class="text-danger">
                                                    {{ number_format($order->total_price, 0, '.', ',') }}đ
                                                </td>
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

                                                    <a href="{{ route('orders.details', $order->order_id) }}"
                                                        class="btn p-2" title="Details">
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

                                                    @can('update order')
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
                                                        </button>
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="js-orders-pagination d-flex justify-content-end my-2">
                                {{ $orders->render('common.ajax-pagination') }}
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
