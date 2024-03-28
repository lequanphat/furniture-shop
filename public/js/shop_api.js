jQuery(document).ready(function () {
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
                const data_asset = $('#asset').attr('data-asset');
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

    $('.detailed-product-tag').click(function () {
        const index = $(this).data('index');
        const sku = $(this).data('sku');

        $('.js-product-name').addClass('d-none');
        $(`.js-product-name.${index}`).removeClass('d-none');
        $('.js-product-price').addClass('d-none');
        $(`.js-product-price.${index}`).removeClass('d-none');
        $(`.js-product-sku`).html(`SKU: ${sku}`);

        $('.js-images-list').addClass('d-none');
        $(`.js-images-list.${index}`).removeClass('d-none');

        $('.js-images-preview').addClass('d-none');
        $(`.js-images-preview.${index}`).removeClass('d-none');
    });

    // filter
    function productFilter() {
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
            `/shop?page=${page}&categories=${categoryIds.join(',')}&color=${colorIds.join(',')}`,
        );
    }
    $('.js-cate-checkbox').change(function () {
        // Your code here
        productFilter();
    });
    $('.js-color-checkbox').change(function () {
        // Your code here
        productFilter();
    });
});
