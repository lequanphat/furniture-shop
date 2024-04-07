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
                    <div>Product</div>
                    <div>Total</div>
                    <div>Paid</div>
                    <div>Status</div>
                    <div>Action</div>
                </div>
                <div class="my-orders-list">
                    @foreach ($orders as $order)
                        <div class="my-order-item">
                            <div>#{{ $order->order_id }}</div>
                            <div class="img-wrapper">
                                @foreach ($order->order_details as $order_detail)
                                    @if ($loop->index == 3)
                                    @break
                                @endif
                                <img src="{{ $order_detail->detailed_product->images->first()->url }}" alt="">
                            @endforeach
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
                        <div class="total-price">{{ $order->is_paid }}</div>
                        <div class="total-price">{{ $order->status }}</div>
                        <div><a href="{{ route('my_detailed_order', $order->order_id) }}">View</a></div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
