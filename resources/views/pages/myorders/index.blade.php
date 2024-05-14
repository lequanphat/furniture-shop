@extends('layouts.app')
@section('content')
    @include('components.head-banner')
    <div class="myorders-main-area pb-100 pt-100">
        <div class="container">
            <div class="row my-orders-list-header">
                <h5>My orders list ({{ $orders->count() }})</h5>
            </div>

            <div class="row my-orders-container">

                <div class="my-orders-list">
                    @if ($orders->count() == 0)
                        <div class="empty-order-list">
                            <img class="" src="{{ asset('images/default/empty-cart.webp') }}" />
                            <p>You don't have any order.</p>
                            <a href="/shop">Go shop</a>
                        </div>
                    @else
                        @foreach ($orders as $order)
                            <div class="order-item">
                                <div class="header">
                                    <p><span class="order-id">#{{ $order->order_id }}</span>
                                        <span class="text-orange">{{ $order->date_time }}</span>
                                    </p>
                                    <div class="tags">
                                        <div class="status-tag">Your order is <span>{{ $order->get_status() }}</span></div>
                                    </div>
                                </div>
                                <div class="content">
                                    @foreach ($order->order_details as $order_detail)
                                        <div class="content-item">
                                            <div class="left">
                                                <img src="@if (isset($order_detail->detailed_product->images->first()->url)) {{ $order_detail->detailed_product->images->first()->url }} @endif"
                                                    alt="">
                                                <div>
                                                    <h5>{{ $order_detail->detailed_product->name }}</h5>
                                                    <p>Phân loại hàng: bàn ghế cao cấp</p>
                                                    <span>{{ $order_detail->quantities }} x
                                                        {{ number_format($order_detail->unit_price, 0, '.', ',') }}đ</span>
                                                </div>
                                            </div>
                                            <div class="right">
                                                {{ number_format($order_detail->quantities * $order_detail->unit_price, 0, '.', ',') }}đ
                                            </div>
                                        </div>
                                    @endforeach



                                </div>
                                <div class="footer">
                                    <p>Total:
                                        <span>{{ number_format(
                                            $order->order_details->reduce(function ($carry, $detail) {
                                                return $carry + $detail->unit_price * $detail->quantities;
                                            }, 0),
                                            0,
                                            '.',
                                            ',',
                                        ) }}đ</span>
                                    </p>
                                    <a href="/myorders/{{ $order->order_id }}">View details</a>
                                </div>
                            </div>
                        @endforeach
                    @endif




                </div>
            </div>
        </div>
    </div>
@endsection
