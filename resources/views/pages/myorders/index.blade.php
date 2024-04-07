@extends('layouts.app')
@section('content')
    @include('components.head-banner')
    <div class="checkout-main-area pb-100 pt-100">
        <div class="container">
            <div class="row">
                <div class="my-orders-filter-wrapper">
                    <div class="filter-item active">All</div>
                    <div class="filter-item">Unconfirm</div>
                    <div class="filter-item">Confirmed</div>
                    <div class="filter-item">In transit</div>
                    <div class="filter-item">Deliverd</div>
                    <div class="filter-item">Cancel</div>
                </div>
            </div>

            <div class="row my-orders-container">
                <div class="my-orders-header">
                    <div>#</div>
                    <div>Order </div>
                    <div>Total</div>
                    <div>Paid</div>
                    <div>Status</div>
                    <div>Time</div>
                    <div>Action</div>
                </div>
                <div class="my-orders-list">
                    @foreach ($orders as $order)
                        <div class="my-order-item">
                            <div>#{{ $order->order_id }}</div>
                            <div class="products-wrapper">
                                <div class="img-wrapper">
                                    <img src="{{ $order->order_details->first()->detailed_product->images->first()->url }}"
                                        alt="">
                                </div>
                                <div class="product-name">
                                    <p>{{ $order->order_details->first()->detailed_product->name }}</p>
                                    <p>{{ $order->order_details->first()->quantities }} x
                                        {{ number_format($order->order_details->first()->unit_price, 0, '.', ',') }}đ</p>
                                </div>
                            </div>
                            <div class="total-price">
                                {{ number_format(
                                    $order->order_details->reduce(function ($carry, $detail) {
                                        return $carry + $detail->unit_price * $detail->quantities;
                                    }, 0),
                                    0,
                                    '.',
                                    ',',
                                ) }}đ
                            </div>
                            <div class="order-paid">{{ $order->is_paid }}</div>
                            <div class="order-status">{{ $order->status }}</div>
                            <div class="order-status">{{ $order->created_at }}</div>
                            <div><a href="{{ route('my_detailed_order', $order->order_id) }}">View</a></div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
