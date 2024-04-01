jQuery(document).ready(function () {
    const data_asset = $('#asset').attr('data-asset');
    $('.pagination-item').click((e) => {
        e.preventDefault();
        $('.pagination-item.active').removeClass('active');
        $(e.target).addClass('active');

        const page = $(e.target).text();
        $.ajax({
            url: `/products?page=${page}`,
            type: 'GET',
            success: function (response) {
                console.log(response);

                const products = response.data;
                let html = '';
                for (let i = 0; i < products.length; i++) {
                    let product = products[i];

                    let image = `${data_asset}images/product/product-5.png`;
                    if (product.detailed_products[0]?.images[0]?.url) {
                        image = `${data_asset}storage/${product.detailed_products[0]?.images[0]?.url}`;
                    }
                    html += `<div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                        <div class="product-img img-zoom mb-25">
                            <a href="/products/${product.product_id}" alt="" style="height: 275px">
                                <img src="${image}" alt="" style="height: 275px">
                            </a>
                            <div class="product-badge badge-top badge-right badge-pink">
                                <span>-5%</span>
                            </div>
                            <div class="product-action-wrap">
                                <a href="/products/${product.product_id}"
                                    class="product-action-btn-1" title="Wishlist"><i
                                        class="pe-7s-like"></i></a>
                                <button class="product-action-btn-1" title="Quick View"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="pe-7s-look"></i>
                                </button>
                            </div>
                            <div class="product-action-2-wrap">
                                <button class="product-action-btn-2" title="Add To Cart"><i
                                        class="pe-7s-cart"></i> Add to cart</button>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a
                                    href="/products/${product.product_id}">${product.name}</a>
                            </h3>
                            <div class="product-price">
                                <span class="old-price">
                                    $1000
                                </span>
                                <span class="new-price">
                                    ${product.detailed_products[0]?.original_price || '999.000đ'}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>`;
                }
                $('#product-list').html(html);
                $('html, body').animate(
                    {
                        scrollTop: $('#product-list').offset().top - 200,
                    },
                    'slow',
                );
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    // helper function
    function enableOrderActionButton(enable) {
        if (enable) {
            $('.js-buy-now').attr('disabled', false);
            $('.js-add-to-cart').attr('disabled', false);
            $('.js-add-to-cart').removeClass('disable');
            $('.js-buy-now').removeClass('disable');
        } else {
            $('.js-buy-now').attr('disabled', true);
            $('.js-add-to-cart').attr('disabled', true);
            $('.js-add-to-cart').addClass('disable');
            $('.js-buy-now').addClass('disable');
        }
    }
    $(document).on('click', '.detailed-product-tag', function (e) {
        // pre process
        if ($(this).hasClass('active')) return;
        $('.detailed-product-tag').removeClass('active');
        $(this).addClass('active');

        const sku = $(this).data('sku');
        $('.js-product-sku').text(sku);
        $(`.js-product-name-price`).addClass('d-none');
        $(`.js-product-name-price.${sku}`).removeClass('d-none');
        $('.js-product-quantities').addClass('d-none');
        $(`.js-product-quantities.${sku}`).removeClass('d-none');
        $('.quantity-input').val(0);
        enableOrderActionButton(false);
        // get data
    });

    $(document).on('click', '.js-quantity-add', function (e) {
        const quantity_input = $('.js-quantity-input');
        const max_value = parseInt($('.js-product-quantities:not(.d-none)').data('quantities'));
        if (quantity_input.val() === '') {
            quantity_input.val(1);
            return;
        }
        const current_value = parseInt(quantity_input.val());
        if (current_value >= max_value) return;
        quantity_input.val(current_value + 1);
        enableOrderActionButton(true);
    });
    $(document).on('click', '.js-quantity-minus', function (e) {
        const quantity_input = $('.js-quantity-input');
        if (quantity_input.val() === '') {
            quantity_input.val(0);
            enableOrderActionButton(false);
            return;
        }
        const current_value = parseInt(quantity_input.val());
        let pre_value = current_value - 1;
        if (pre_value <= 0) {
            quantity_input.val(0);
            enableOrderActionButton(false);
        } else {
            quantity_input.val(pre_value);
        }
    });

    $('.js-quantity-input').on('input', function (e) {
        const quantity_input = $('.js-quantity-input');
        const max_value = parseInt($('.js-product-quantities:not(.d-none)').data('quantities'));
        const current_value = parseInt(quantity_input.val());
        if (current_value >= max_value) {
            quantity_input.val(max_value);
        } else if (current_value <= 0) {
            quantity_input.val(0);
        }
    });

    $('.js-add-to-cart').on('click', function (e) {
        const quantity_input = $('.js-quantity-input');
        let quantities = parseInt(quantity_input.val());
        const sku = $('.detailed-product-tag.active').data('sku');
        const unit_price = $('.js-product-name-price:not(.d-none) .js-unit-price').text();
        const name = $('.js-product-name-price:not(.d-none) .js-product-name').text();
        const image = $('.detailed-product-tag.active img').attr('src');
        console.log('add to cart', { quantities, sku, unit_price, name, image });

        // save to local storage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].sku === sku) {
                cart[i].quantities += quantities;
                localStorage.setItem('cart', JSON.stringify(cart));
                return;
            }
        }
        cart.push({ sku, quantities, unit_price, name, image });
        $('.js-total-cart').text(cart.length);
        $('.js-total-cart').addClass('bg-black');
        localStorage.setItem('cart', JSON.stringify(cart));
    });

    // filter
    function productFilter() {
        // search
        const search_text = $('#search-input').val();
        // sort
        const sorted_by = $('#sort-product').val();
        // page
        const page = $('.pagination-item.active').text();
        console.log(page);
        // category
        const categories = $('.js-cate-checkbox');
        const categoryIds = [];
        for (let category of categories) {
            if (category.checked) {
                categoryIds.push(category.dataset.id);
            }
        }
        // color
        const colors = $('.js-color-checkbox');
        const colorIds = [];
        for (let color of colors) {
            if (color.checked) {
                colorIds.push(color.dataset.id);
            }
        }
        if (colorIds.length === 0) {
            colorIds.push('all');
        }
        if (categoryIds.length === 0) {
            categoryIds.push('all');
        }
        history.pushState(
            null,
            null,
            `/shop?page=${page}&categories=${categoryIds.join(',')}&color=${colorIds.join(
                ',',
            )}&search=${search_text}&sorted_by=${sorted_by}`,
        );
        $.ajax({
            url: `/products?page=${page}&categories=${categoryIds.join(',')}&color=${colorIds.join(
                ',',
            )}&search=${search_text}&sorted_by=${sorted_by}`,
            type: 'GET',
            success: function (response) {
                let html = '';
                for (let i = 0; i < response.products.data.length; i++) {
                    let product = response.products.data[i];
                    let image = `${data_asset}images/product/product-5.png`;
                    if (product.detailed_products[0]?.images[0]?.url) {
                        image = product.detailed_products[0]?.images[0]?.url;
                    }
                    html += `<div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                        <div class="product-img img-zoom mb-25">
                            <a href="/products/${product.product_id}">
                                <img src="${image}" alt="" style="height: 275px">
                            </a>
                            <div class="product-badge badge-top badge-right badge-pink">
                                <span>-10%</span>
                            </div>
                            <div class="product-action-wrap">
                                <a href="/products/${product.product_id}"
                                    class="product-action-btn-1" title="Wishlist"><i
                                        class="pe-7s-like"></i></a>
                                <button class="product-action-btn-1" title="Quick View"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="pe-7s-look"></i>
                                </button>
                            </div>
                            <div class="product-action-2-wrap">
                                <button class="product-action-btn-2" title="Add To Cart"><i
                                        class="pe-7s-cart"></i> Add to cart</button>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a
                                    href="/products/${product.product_id}">${product.name}</a>
                            </h3>
                            <div class="product-price">
                                <span class="old-price">
                                    $1000
                                </span>
                                <span class="new-price">
                                    ${product.detailed_products[0]?.original_price || '999.000đ'}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>`;
                }
                $('#product-list').html(html);
            },
            error: function (error) {
                console.log(error);
            },
        });
    }

    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // search filter
    $('#search-input').on(
        'input',
        debounce(function () {
            productFilter();
        }, 500),
    );

    // sorted
    $('#sort-product').change(function () {
        productFilter();
    });
    // category filter
    $('.js-cate-checkbox').change(function () {
        productFilter();
    });

    // color filter
    $('.js-color-checkbox').change(function () {
        productFilter();
    });
});
