@extends('layouts.app')
@section('content')
    {{-- Head banner --}}
    @include('components.head-banner')

    <div class="checkout-main-area pb-100 pt-100">
        <div class="container">
            <form id="checkout-form" action={{ route('checkout') }} method="POST" class="checkout-wrap pt-30">
                @csrf
                <div class="row">
                    <div class="col-lg-7">
                        <div class="billing-info-wrap">
                            <h3>Billing Details</h3>
                            @if (Auth::user())
                                @if (isset(Auth::user()->default_address))
                                    <div class="row close-toggle">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-20">
                                                <label>Receiver name <abbr class="required"
                                                        title="required">*</abbr></label>
                                                <input id="receiver_name" type="text" name="receiver_name"
                                                    value="{{ Auth::user()->full_name() }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-20">
                                                <label>Phone <abbr class="required" title="required">*</abbr></label>
                                                <input id="phone_number" type="phone" name="phone_number"
                                                    value="{{ Auth::user()->default_address->phone_number }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="billing-info mb-20">
                                                <label>Street Address <abbr class="required"
                                                        title="required">*</abbr></label>
                                                <input id="address" class="billing-address" type="text" name="address"
                                                    value="{{ Auth::user()->default_address->address }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="change-address-wrapper">
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#select-address-modal"><i class="ti-pencil-alt"></i>
                                                    Another
                                                    address</button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row close-toggle">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-20">
                                                <label>Receiver name <abbr class="required"
                                                        title="required">*</abbr></label>
                                                <input id="receiver_name" type="text" name="receiver_name" value=""
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-20">
                                                <label>Phone <abbr class="required" title="required">*</abbr></label>
                                                <input id="phone_number" type="phone" name="phone_number" value=""
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="billing-info mb-20">
                                                <label>Street Address <abbr class="required"
                                                        title="required">*</abbr></label>
                                                <input id="address" class="billing-address" type="text" name="address"
                                                    value="" placeholder="">
                                            </div>
                                        </div>

                                        <p id="checkout-error" class="text-danger d-none"></p>

                                    </div>
                                @endif
                            @endif
                            <div class="additional-info-wrap">
                                <label>Order notes</label>
                                <textarea id="note" name="note" placeholder="Notes about your order, e.g. special notes for delivery. "></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="your-order-area">
                            <h3>Your order</h3>
                            <div class="your-order-wrap gray-bg-4">
                                <div class="your-order-info-wrap">
                                    <div class="your-order-info">
                                        <ul>
                                            <li>Product <span class="js-checkout-total-product">...</span></li>
                                        </ul>
                                    </div>
                                    <div class="your-order-middle">
                                        <ul class="js-checkout-product">


                                        </ul>
                                    </div>

                                    <div class="your-order-info order-total">
                                        <ul>
                                            <li>Total <span class="js-checkout-total-price">...</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="payment-method">
                                    <label class="payment-method-label" for="cash-on-delivery">
                                        <i class="fa-solid fa-truck-fast"></i>
                                        <span>Cash on delivery</span>
                                        <input type="radio" name="payment_method" id="cash-on-delivery"
                                            value="cash-on-delivery" checked>
                                        <div class="mark"></div>
                                    </label>
                                    <label class="payment-method-label" for="payment-with-vnpay">
                                        <i class="fa-solid fa-credit-card"></i>
                                        <span>Payment with VNPay</span>
                                        <input type="radio" name="payment_method" id="payment-with-vnpay" value="vnpay">
                                        <div class="mark"></div>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="place-order-btn">Place order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Modal --}}
    @include('pages.checkout.select-address-modal')
@endsection
