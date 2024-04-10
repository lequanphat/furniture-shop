@extends('layouts.app')
@section('content')
    {{-- Head banner --}}
    @include('components.head-banner')
    <div class="checkout-main-area pb-100 pt-100">
        <div class="container">

            <div class="row checkout-container">
                @if (isset($order->order_id))
                    <div class="col-8 checkout-left order-padding">
                        <div class="top">
                            <img class="checkout-icon" src="{{ asset('svg/checkout-success.svg') }}" />
                            <div class="checkout-message">
                                <h2>Your order is {{ $order->get_status }}</h2>
                                <p>We will be sending you an email confirmation to <span>{{ Auth::user()->email }}</span>
                                    shortly
                                </p>
                            </div>
                            <div class="checkout-status">
                                <p class="title">Order <a href="">#{{ $order->order_id }}</a> was placed on
                                    <span>{{ $order->created_at }}</span>
                                    and is currently
                                    in progress
                                </p>
                                <div class="status-progress">
                                    @if ($order->status == 4)
                                        <div class="progress-item active "><i class="fa-solid fa-clock"></i><span>Await
                                                confirm</span></div>
                                        <div class="progress-line cancel "></div>
                                        <div class="progress-item cancel "><i
                                                class="fa-solid fa-xmark"></i><span>Canceled</span></div>
                                    @else
                                        <div class="progress-item @if ($order->status >= 0) active @endif"><i
                                                class="fa-solid fa-clock"></i><span>Await confirm</span></div>
                                        <div class="progress-line @if ($order->status >= 1) active @endif"></div>
                                        <div class="progress-item @if ($order->status >= 1) active @endif"><i
                                                class="fa-solid fa-check"></i><span>Comfirmed</span></div>
                                        <div class="progress-line @if ($order->status >= 2) active @endif"></div>
                                        <div class="progress-item @if ($order->status >= 2) active @endif"><i
                                                class="fa-solid fa-truck"></i><span>In transit</span></div>
                                        <div class="progress-line @if ($order->status >= 3) active @endif"></div>
                                        <div class="progress-item @if ($order->status >= 3) active @endif"><i
                                                class="fa-solid fa-thumbs-up"></i><span>Deliverd</span></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="checkout-footer justify-between">
                            <a class="btn" href="/myorders">Back to orders</a>
                            <a class="btn">Cancel order</a>
                        </div>
                    </div>
                    <div class="col-4 checkout-right">
                        @if ($order->is_paid)
                            <div class="paid-tag">Paid</div>
                        @else
                            <div class="paid-tag unpaid">Unpaid</div>
                        @endif
                        <div class="header">
                            <h3>Order detail</h3>
                            <h2>#{{ $order->order_id }}</h2>
                        </div>
                        <div class="content">
                            <div class="delivery-address">
                                <h3>Delivery address</h3>
                                <p>{{ $order->receiver_name }} {{ $order->phone_number }}</p>
                                <p>{{ $order->address }}</p>
                            </div>
                            <div class="order-summary">
                                <h3>order summary</h3>
                                @foreach ($order->order_details as $detailed_order)
                                    <div class="item">
                                        <p>x{{ $detailed_order->quantities }}
                                            <a
                                                href="/products/{{ $detailed_order->detailed_product->product_id }}">{{ $detailed_order->detailed_product->name }}</a>

                                        </p>
                                        <p>{{ number_format($detailed_order->unit_price * $detailed_order->quantities, 0, '.', ',') }}đ
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            @if (isset($order->note))
                                <div class="order-note">
                                    <h3>Order Note</h3>
                                    <p>{{ $order->note }}</p>
                                </div>
                            @endif

                        </div>
                        <div class="footer">
                            <h3>Total</h3>
                            <span>{{ number_format(
                                $order->order_details->reduce(function ($carry, $detail) {
                                    return $carry + $detail->unit_price * $detail->quantities;
                                }, 0),
                                0,
                                '.',
                                ',',
                            ) }}đ</span>
                        </div>
                    </div>
                @else
                    <p>Can not find this order</p>
                @endif
            </div>

        </div>
    </div>
@endsection
