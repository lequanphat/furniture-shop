 <!-- mini cart start -->
 <div class="sidebar-cart-active">
     <div class="sidebar-cart-all">
         <div class="cart-content">
             <h3>Shopping Cart</h3>
             <ul id="cart-list">
                 {{-- render cart here --}}
             </ul>
             <div class="cart-total">
                 <h4>Total Price: <span class="js-total-price">$170.00</span></h4>
             </div>
             <div class="product-details-action-wrap">
                 <a href="/cart" class="add-to-cart">View cart</a>
                 <a class="js-mini-cart-checkout-btn buy-now">Checkout</a>
             </div>
         </div>
     </div>
 </div>
 <script src="{{ asset('js/cart.js') }}" defer></script>
