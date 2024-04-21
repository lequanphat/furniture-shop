jQuery(document).ready(function () {
    let formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 0,
    });
    $.ajax({
        url: `/lastproducts`,
        type: 'GET',
        success: function (response) {
          //  console.log(response.products.data);
            let html = '';
            response.products.data.forEach((product) => {
                    html += `<div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                        <div class="custom-product-img product-img img-zoom mb-25">
                            <a href="/products/${product.product_id}">
                                <img src="${product.detailed_product.image}" alt="" style="height: 275px">
                            </a>
                            <div class="product-badge badge-top badge-right badge-pink">
                            ${
                                product.detailed_product.total_discount_percentage > 0
                                    ? `<span>-${product.detailed_product.total_discount_percentage}%</span>`
                                    : ''
                            }
                            </div>
                            ${
                                product.total_quantities == 0
                                    ? ` <div class="custom-product-badge product-badge badge-top badge-left badge-pink">
                                <span>Sold out</span>
                            </div>`
                                    : ''
                            }
                            
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
                            ${
                                product.detailed_product.total_discount_percentage > 0
                                    ? `<span class="old-price">
                                    ${formatter.format(product.detailed_product.original_price)}đ
                                    </span>`
                                    : ''
                            } 
                            
                                <span class="new-price">
                                    ${formatter.format(product.detailed_product.original_price)}đ
                                </span>
                            </div>
                        </div>
                    </div>
                </div>`;
            })
            $('#pro-1-content').html(html);
        },
        error: function (error) {
            console.log(error);
        },
    });
   /* $.ajax({
        url: `/bestseller`,
        type: 'GET',
        success: function (response) {
          //  console.log(response);
            let html = '';
            response.products.data.forEach((product) => {
                    html += `<div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                        <div class="custom-product-img product-img img-zoom mb-25">
                            <a href="/products/${product.product_id}">
                                <img src="${product.detailed_product.image}" alt="" style="height: 275px">
                            </a>
                            <div class="product-badge badge-top badge-right badge-pink">
                            ${
                                product.detailed_product.total_discount_percentage > 0
                                    ? `<span>-${product.detailed_product.total_discount_percentage}%</span>`
                                    : ''
                            }
                            </div>
                            ${
                                product.total_quantities == 0
                                    ? ` <div class="custom-product-badge product-badge badge-top badge-left badge-pink">
                                <span>Sold out</span>
                            </div>`
                                    : ''
                            }
                            
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
                            <h6>Sold ${product.sold}<h6>
                            <div class="product-price">
                            ${
                                product.detailed_product.total_discount_percentage > 0
                                    ? `<span class="old-price">
                                    ${formatter.format(product.detailed_product.original_price)}đ
                                    </span>`
                                    : ''
                            } 
                            
                                <span class="new-price">
                                    ${formatter.format(product.detailed_product.original_price)}đ
                                </span>
                            </div>
                        </div>
                    </div>
                </div>`;
            })
            $('#pro-2-content').html(html);
        },
        error: function (error) {
            console.log(error);
        },
    });*/
    $.ajax({
        url: '/top5deal',
        method: 'GET',
        datatype: 'JSON',
        success: function (response) {
            console.log(response);
            const productContainer = $('#deal_of_day');
            productContainer.empty();
            var i = 1;
            if(response)
            {
                productContainer.append(`<span>Current don't have any deal of day</span>`)
            }
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
                                <span class="old-price">$${product.old_price}đ </span>
                                <span class="new-price">$${product.new_price}đ </span>
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
