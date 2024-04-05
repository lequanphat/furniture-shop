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
                                <div class="row close-toggle">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info mb-20">
                                            <label>Receiver name <abbr class="required" title="required">*</abbr></label>
                                            <input type="text" name="receiver_name"
                                                value="{{ Auth::user()->full_name() }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info mb-20">
                                            <label>Phone <abbr class="required" title="required">*</abbr></label>
                                            <input type="phone" name="phone_number"
                                                value="{{ Auth::user()->default_address->phone_number }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="billing-info mb-20">
                                            <label>Street Address <abbr class="required" title="required">*</abbr></label>
                                            <input class="billing-address" type="text" name="address"
                                                value="{{ Auth::user()->default_address->address }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="change-address-wrapper">
                                            <button>Choose another address</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="checkout-account mt-25">
                                    <input class="checkout-toggle" type="checkbox">
                                    <span>Ship to a different address?</span>
                                </div>
                                <div class="different-address open-toggle mt-30">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-20">
                                                <label>First Name</label>
                                                <input type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="billing-info mb-20">
                                                <label>Phone</label>
                                                <input type="text">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="billing-info mb-20">
                                                <label>Street Address</label>
                                                <input class="billing-address" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="additional-info-wrap">
                                <label>Order notes</label>
                                <textarea placeholder="Notes about your order, e.g. special notes for delivery. " name="message"></textarea>
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
                                    <div class="pay-top sin-payment">
                                        <input id="payment-method-2" class="input-radio" type="radio"
                                            value="cash-on-delivery" name="payment_method" checked>
                                        <label for="payment-method-2">Cash on delivery </label>
                                        <div class="payment-box payment_method_bacs">
                                            <p>Make your payment directly into our bank account. Please use your Order ID as
                                                the payment reference.</p>
                                        </div>
                                    </div>
                                    <div class="pay-top sin-payment">
                                        <input id="payment-method-1" class="input-radio" type="radio"
                                            value="check-payments" name="payment_method">
                                        <label for="payment-method-1">Check payments</label>
                                        <div class="payment-box payment_method_bacs">
                                            <p>Make your payment directly into our bank account. Please use your Order ID as
                                                the payment reference.</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="place-order-btn">Place order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
