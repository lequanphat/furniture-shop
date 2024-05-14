@extends('layouts.app')
@section('content')
    {{-- Head banner --}}
    @include('components.head-banner')
    <div class="cart-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div id="cart-section" class="col-8">
                    <div class="cart-header">
                        <div><span>Product</span></div>
                        <div><span>Unit price</span></div>
                        <div><span>Quantities</span></div>
                        <div><span>Total price</span></div>
                        <div><span></span></div>
                    </div>
                    <div id="js-cart-table" class="cart-content">
                        {{-- render cart here --}}
                    </div>
                </div>
                <div id="checkout-cart" class="col-lg-4 col-md-12 col-12">
                    <p class="title">Order Summary</p>
                    <div class="js-checkout-content checkout-content">
                        {{-- render checkout here --}}
                    </div>
                    <div class="separate"></div>
                    <div class="total-price-wrapper">
                        <p class="title">Order Total:</p>
                        <p class="js-cart-order-total-price total-price">0đ</p>
                    </div>
                    <div class="separate"></div>
                    <button class="js-cart-checkout-btn checkout disable">Checkout</button>

                    <a href="/shop" class="continue-shopping">Continue Shopping</a>
                </div>
            </div>

        </div>
    </div>
@endsection
