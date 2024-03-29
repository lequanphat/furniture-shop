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

    $('.detailed-product-tag').click(function (e) {
        // pre process
        if ($(this).hasClass('active')) return;
        $('.detailed-product-tag').removeClass('active');
        $(this).addClass('active');
        $('.js-product-sku').text($(this).data('sku'));
        // get data
        const product_id = $(this).data('id');
        const sku = $(this).data('sku');

        history.pushState(null, null, `/products/${product_id}/${sku}`);
        // call api
        $.ajax({
            url: `/products/${sku}`,
            type: 'GET',
            success: function (response) {
                console.log(response);
                // render ui

                let images_list = '';
                let images_preview = '';
                for (let i = 0; i < response.detailed_product.images.length; i++) {
                    let image = response.detailed_product.images[i];
                    images_list += `<div class="swiper-slide ${
                        i === 0 && 'swiper-slide-active swiper-slide-thumb-active'
                    }  ${i === 1 && 'swiper-slide-next'} ">
                    <div class="product-details-small-img">
                        <img src="${image.url}" alt="Product Thumnail">
                    </div>
                </div>`;
                    images_preview += `<div class="swiper-slide ${
                        i === 0 && 'swiper-slide-active swiper-slide-thumb-active'
                    }  ${i === 1 && 'swiper-slide-next'} ">
                    <div class="easyzoom-style">
                        <div class="easyzoom easyzoom--overlay">

                            <a href="${image.url}">
                                <img src="${image.url}" alt="">
                            </a>
                        </div>
                        <a class="easyzoom-pop-up img-popup" href="${image.url}">
                            <i class="pe-7s-search"></i>
                        </a>
                    </div>
                </div>`;
                }
                $('.js-images-list').html(images_list);
                $('.js-images-preview').html(images_preview);

                $('.js-product-name').text(response.detailed_product.name);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    // filter
    function productFilter() {
        // search
        const search_text = $('#search-input').val();
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
            `/shop?page=${page}&categories=${categoryIds.join(',')}&color=${colorIds.join(',')}&search=${search_text}`,
        );
        $.ajax({
            url: `/products?page=${page}&categories=${categoryIds.join(',')}&color=${colorIds.join(
                ',',
            )}&search=${search_text}`,
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

    // category filter
    $('.js-cate-checkbox').change(function () {
        productFilter();
    });

    // color filter
    $('.js-color-checkbox').change(function () {
        productFilter();
    });
});
