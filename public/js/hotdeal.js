jQuery(document).ready(function () {
    $.ajax({
        url: '/top5deal',
        method: 'GET',
        datatype: 'JSON',
        success: function (response) {
            console.log(response);
            const productContainer = $('#deal_of_day');
            productContainer.empty();
            var i = 1;
            response.forEach(function (product) {
                var url = product.url;
                if (!url) {
                    url = 'images/product/product-9.png';
                }
                productContainer.append(`
                <div class="swiper-slide">
                    <div class="product-wrap" data-aos="fade-up" data-aos-delay="${i * 200}">
                        <div class="product-img img-zoom mb-25">
                            <a href="/products/${product.product_id}">
                                <img src="${url}" alt="">
                            </a>
                            <div class="product-badge badge-top badge-right badge-pink">
                                <span>-${product.discount_percent}%</span>
                            </div>
                            <div class="product-action-wrap">
                                <a href="/products/${
                                    product.product_id
                                }" class="product-action-btn-1" title="Wishlist"><i
                                        class="pe-7s-like"></i></a>
                                <button class="product-action-btn-1" title="Quick View" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="pe-7s-look"></i>
                                </button>
                            </div>
                            <div class="product-action-2-wrap">
                                <button class="product-action-btn-2" title="Add To Cart"><i class="pe-7s-cart"></i>
                                    Add to cart</button>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="/products/${product.product_id}">${product.name}</a></h3>
                            <div class="product-price">
                                <span class="old-price">$${product.old_price} </span>
                                <span class="new-price">$${product.new_price} </span>
                            </div>
                        </div>
                    </div>
                </div>
                `);
                i++;
            });
        },
        error: function (error) {
            console.log('error');
            console.log({ error });
        },
    });
});
