 <!-- mini cart start -->
 <div class="sidebar-cart-active">
     <div class="sidebar-cart-all">
         <a class="cart-close" href="#"><i class="pe-7s-close"></i></a>
         <div class="cart-content">
             <h3>Shopping Cart</h3>
             <ul>
                 <li>
                     <div class="cart-img">
                         <a href="{{ asset('images/cart/cart-1.jpg') }}"><img src="{{ asset('images/cart/cart-1.jpg') }}"
                                 alt=""></a>
                     </div>
                     <div class="cart-title">
                         <h4><a href="#">Stylish Swing Chair</a></h4>
                         <span> 1 × $49.00 </span>
                     </div>
                     <div class="cart-delete">
                         <a href="#">×</a>
                     </div>
                 </li>
                 <li>
                     <div class="cart-img">
                         <a href="{{ asset('images/cart/cart-2.jpg') }}"><img
                                 src="{{ asset('images/cart/cart-2.jpg') }}" alt=""></a>
                     </div>
                     <div class="cart-title">
                         <h4><a href="#">Modern Chairs</a></h4>
                         <span> 1 × $49.00 </span>
                     </div>
                     <div class="cart-delete">
                         <a href="#">×</a>
                     </div>
                 </li>
             </ul>
             <div class="cart-total">
                 <h4>Subtotal: <span>$170.00</span></h4>
             </div>
             <div class="cart-btn btn-hover">
                 <a class="theme-color" href="/cart">view cart</a>
             </div>
             <div class="checkout-btn btn-hover">
                 <a class="theme-color" href="/checkout">checkout</a>
             </div>
         </div>
     </div>
 </div>
