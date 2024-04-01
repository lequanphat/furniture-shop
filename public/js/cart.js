jQuery(document).ready(function () {
    // init cart
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length > 0) {
        $('.js-total-cart').text(cart.length);
        $('.js-total-cart').addClass('bg-black');
    } else {
        $('.js-total-cart').removeClass('bg-black');
    }
    function convertCurrencyToNumber(currency) {
        return Number(currency.replace(/,|đ/g, ''));
    }
    let formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 0,
    });

    // load cart
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
    });
});
