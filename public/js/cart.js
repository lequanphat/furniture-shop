jQuery(document).ready(function () {
    function showToast(message, type) {
        let background = '#0097e6';
        if (type === 'success') background = '#4cd137';
        else if (type === 'error') background = '#e84118';
        Toastify({
            text: message,
            close: true,
            style: {
                background,
            },
            duration: 3000,
        }).showToast();
    }
    // init cart
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length > 0) {
        $('.js-total-cart').text(cart.length);
        $('.js-total-cart').addClass('bg-black');
    } else {
        $('.js-total-cart').removeClass('bg-black');
    }
    function convertCurrencyToNumber(currency) {
        if (currency.includes(',') || currency.includes('đ')) {
            return Number(currency.replace(/,|đ/g, ''));
        } else {
            return Number(currency);
        }
    }
    let formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 0,
    });

    // load mini cart
    $('.header-action-cart').on('click', function () {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        let html = '';
        let total_price = 0;
        for (let i = 0; i < cart.length; i++) {
            item = cart[i];
            total_price += convertCurrencyToNumber(item.unit_price) * item.quantities;
            html += `<li>
                    <div class="cart-item-info">
                        <div class="cart-img">
                            <a href="#"><img src="${item.image}" alt=""></a>
                        </div>
                        <div class="cart-title">
                            <h4><a>${item.name}</a></h4>
                            <span> ${item.quantities} × <span class="unit-price">${item.unit_price}</span> </span>
                        </div>
                    </div>
                    <div class="cart-delete">
                        <a class="js-delete-cart-item" data-sku="${item.sku}"><i class="ti-close"></i></a>
                    </div>
                </li>`;
        }
        $('#cart-list').html(html);
        $('.js-total-price').text(formatter.format(total_price) + 'đ');
    });
    // delete cart item
    $(document).on('click', '.js-delete-cart-item', function (e) {
        const sku = $(this).data('sku');
        $(this).closest('li').remove();
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const newCart = cart.filter((item) => item.sku !== sku);
        localStorage.setItem('cart', JSON.stringify(newCart));
        $('.js-total-cart').text(newCart.length);
        if (newCart.length === 0) $('.js-total-cart').removeClass('bg-black');

        let total_price = 0;
        for (let i = 0; i < newCart.length; i++) {
            item = cart[i];
            total_price += convertCurrencyToNumber(item.unit_price) * item.quantities;
        }
        $('.js-total-price').text(formatter.format(total_price) + 'đ');
    });

    // cart page
    function loadCart() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let html = '';
        for (let i = 0; i < cart.length; i++) {
            let item = cart[i];
            html += `<div class="js-cart-item cart-item">
            <div class="product-cart-item">
                <input class="js-check-cart-item" type="checkbox" name="" id="">
                <img src="${item.image}" alt="">
                <div class="info">
                    <p> ${item.name} </p>
                    <p class="js-sku">${item.sku}</p>
                </div>
            </div>
            <div><span class="js-unit-price">${item.unit_price}</span></div>
            <div>
                <div class="quantities-wrapper">
                    <button class="js-quantities-minus" ><i class="ti-minus"></i></button>
                    <input class="js-cart-quantities-input" type="number" value="${item.quantities}">
                    <button class="js-quantities-plus" ><i class="ti-plus"></i></button>
                </div>
            </div>
            <div><span class="js-subtotal-price">${formatter.format(
                convertCurrencyToNumber(item.unit_price) * item.quantities,
            )}đ</span></div>
            <div class="js-delete-cart-item delete-item"><i class="ti-close"></i></div>
            </div>`;
        }
        $('#js-cart-table').html(html);
    }
    loadCart();
    $(document).on('click', '.js-quantities-minus', function () {
        let quantities = $(this).siblings('input').val();
        quantities = Number(quantities) - 1;
        if (quantities < 1) quantities = 1;
        $(this).siblings('input').val(quantities);

        // set subtotal price
        const unit_price = convertCurrencyToNumber($(this).closest('.cart-item').find('.js-unit-price').text());
        $(this)
            .closest('.cart-item')
            .find('.js-subtotal-price')
            .text(formatter.format(unit_price * quantities) + 'đ');

        // update cart
        const sku = $(this).closest('.cart-item').find('.js-sku').text();
        console.log(sku);
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const newCart = cart.map((item) => {
            if (item.sku === sku) {
                item.quantities = quantities;
            }
            return item;
        });
        localStorage.setItem('cart', JSON.stringify(newCart));
        loadCartCheckout();
    });
    $(document).on('click', '.js-quantities-plus', function () {
        let quantities = $(this).siblings('input').val();
        quantities = Number(quantities) + 1;
        $(this).siblings('input').val(quantities);

        // set subtotal price
        const unit_price = convertCurrencyToNumber($(this).closest('.cart-item').find('.js-unit-price').text());

        $(this)
            .closest('.cart-item')
            .find('.js-subtotal-price')
            .text(formatter.format(unit_price * quantities) + 'đ');

        // update cart
        const sku = $(this).closest('.cart-item').find('.js-sku').text();
        console.log(sku);
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const newCart = cart.map((item) => {
            if (item.sku === sku) {
                item.quantities = quantities;
            }
            return item;
        });
        localStorage.setItem('cart', JSON.stringify(newCart));
        loadCartCheckout();
    });
    $(document).on('change', '.js-cart-quantities-input', function () {
        let quantities = $(this).val();
        if (quantities < 1) quantities = 1;
        $(this).val(quantities);

        // set subtotal price
        const unit_price = convertCurrencyToNumber($(this).closest('.cart-item').find('.js-unit-price').text());
        $(this)
            .closest('.cart-item')
            .find('.js-subtotal-price')
            .text(formatter.format(unit_price * quantities) + 'đ');

        // update cart
        const sku = $(this).closest('.cart-item').find('.js-sku').text();
        console.log(sku);
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const newCart = cart.map((item) => {
            if (item.sku === sku) {
                item.quantities = quantities;
            }
            return item;
        });
        localStorage.setItem('cart', JSON.stringify(newCart));
        loadCartCheckout();
    });
    $(document).on('click', '.js-delete-cart-item', function () {
        const sku = $(this).closest('.cart-item').find('.js-sku').text();
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const newCart = cart.filter((item) => item.sku !== sku);
        localStorage.setItem('cart', JSON.stringify(newCart));
        $(this).closest('.cart-item').remove();
        loadCartCheckout();
    });

    function loadCartCheckout() {
        let cart_items = $('.js-cart-item');
        cart_items = cart_items.filter(function (cart_item) {
            return $(this).find('.js-check-cart-item').prop('checked');
        });
        let html = '';
        let total_price = 0;
        cart_items.each(function () {
            const sku = $(this).find('.info p.js-sku').text();
            const name = $(this).find('.info p:not(.js-sku)').text();
            const quantities = parseInt($(this).find('.js-cart-quantities-input').val());
            const unit_price = convertCurrencyToNumber($(this).find('.js-unit-price').text());
            html += `<div class="checkout-item" data-sku="${sku}" data-unit-price="${unit_price}" data-quantities="${quantities}">
                        <p>x<span>${quantities}</span> <span>${name}</span></p>
                        <p>${formatter.format(unit_price * quantities)}đ</p>
                    </div>`;
            total_price += unit_price * quantities;
        });
        $('.js-checkout-content').html(html);
        $('.js-cart-order-total-price').text(formatter.format(total_price) + 'đ');
    }
    $(document).on('click', '.js-check-cart-item', function () {
        loadCartCheckout();
    });

    $(document).on('click', '.js-cart-checkout-btn', function () {
        let checkout_items = $('.checkout-item');
        let checkout = [];
        for (let i = 0; i < checkout_items.length; i++) {
            const item = checkout_items[i];
            const sku = $(item).data('sku');
            const name = $(item).find('span').eq(1).text();
            const unit_price = $(item).data('unit-price');
            const quantities = $(item).data('quantities');
            checkout.push({ sku, name, unit_price, quantities });
        }
        localStorage.setItem('checkout', JSON.stringify(checkout));
        window.location.href = '/checkout';
    });
    $(document).on('click', '.js-mini-cart-checkout-btn', function () {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        localStorage.setItem('checkout', JSON.stringify(cart));
        window.location.href = '/checkout';
    });

    function loadCheckoutProduct() {
        const checkout = JSON.parse(localStorage.getItem('checkout')) || [];
        let total_price = 0;
        let total_quantities = 0;
        for (let i = 0; i < checkout.length; i++) {
            const item = checkout[i];
            let subtotal_price = convertCurrencyToNumber(item.unit_price + '') * parseInt(item.quantities);
            total_price += subtotal_price;
            total_quantities += parseInt(item.quantities);
            $('.js-checkout-product').append(
                `<li>x${item.quantities} ${item.name} <span>${formatter.format(subtotal_price)}đ</span></li>`,
            );
        }
        $('.js-checkout-total-product').text(total_quantities + ' products');
        $('.js-checkout-total-price').text(formatter.format(total_price) + 'đ');
    }
    loadCheckoutProduct();

    $(document).on('click', '.js-change-address', function () {
        var checkedRadio = $('.address-item input[type=radio]:checked');
        if (checkedRadio.length > 0) {
            var addressItem = checkedRadio.closest('.address-item');
            var receiverName = addressItem.find('.heading p').first().text();
            var phoneNumber = addressItem.find('.heading p').last().text();
            var address = addressItem.find('p').not('.heading p').text();
            $('#receiver-name').val(receiverName);
            $('#phone-number').val(phoneNumber);
            $('#address').val(address);
        } else {
            console.log('No address selected');
        }
    });
    $(document).on('submit', '#checkout-form', function (event) {
        event.preventDefault();
        let data = $(this).serialize();

        let checkout = JSON.parse(localStorage.getItem('checkout')) || [];
        if (checkout.length === 0) {
            showToast('No product in cart', 'error');
            return;
        }
        checkout = checkout.map((item) => ({
            sku: item.sku,
            quantities: item.quantities,
            unit_price: convertCurrencyToNumber(item.unit_price + ''),
        }));
        data += `&checkout=${JSON.stringify(checkout)}`;
        $.ajax({
            url: '/checkout',
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                // delete checkout storage
                localStorage.removeItem('checkout');

                // redirect to checkout page
                console.log('====================================');
                console.log(response);
                console.log('====================================');
                window.location.href = `/checkout/${response.order.order_id}`;
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
