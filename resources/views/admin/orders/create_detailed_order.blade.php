<div class="modal fade" id="create-detailed-order-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="create-order-form" action="#" method="dialog" class="w-full h-full">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add products into order</h5>
                    <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                        aria-label="Close"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="input-icon col-12">
                                <input id="search-detailed-products" name="search" type="text" value=""
                                    class="form-control" placeholder="Search here…" autocomplete="off">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="table-responsive" style="min-height: 344px">
                                        <table class="js-user-table table table-vcenter card-table">
                                            <thead>
                                                <tr>ord
                                                    <th>Product</th>
                                                    <th>Color & Size</th>
                                                    <th>Quantities</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detailed-products-table">
                                                @foreach ($detailed_products as $detailed_product)
                                                    @php
                                                        $today = now();
                                                        $discount_percentage = $detailed_product->product_discounts
                                                            ->where('discount.start_date', '<=', $today)
                                                            ->where('discount.end_date', '>=', $today)
                                                            ->sum('discount.percentage');

                                                        $unit_price =
                                                            $detailed_product->original_price -
                                                            ($detailed_product->original_price * $discount_percentage) /
                                                                100;
                                                    @endphp
                                                    <tr data-sku="{{ $detailed_product->sku }}">
                                                        <td>
                                                            <div class="d-flex py-1 align-items-center">
                                                                <span class="avatar me-2 custom-product-image"
                                                                    style="background-image: url(@if (isset($detailed_product->images->first()->url)) {{ $detailed_product->images->first()->url }} @endif);">
                                                                </span>
                                                                <div class="flex-1">
                                                                    <div class="font-weight-medium">
                                                                        <h4 class="m-0">{{ $detailed_product->name }}
                                                                        </h4>
                                                                    </div>
                                                                    <div class="text-muted">
                                                                        <a
                                                                            href="#"class="text-reset">#{{ $detailed_product->sku }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p class="text-reset m-0">
                                                                    {{ $detailed_product->color->name }}</p>
                                                            </div>
                                                            <div class="text-muted ">
                                                                <p class="text-reset m-0">{{ $detailed_product->size }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="js-detailed-product-quantities">
                                                            {{ $detailed_product->quantities }}</td>
                                                        <td>
                                                            @if ($discount_percentage > 0)
                                                                <del>{{ number_format($detailed_product->original_price, 0, '.', ',') }}đ</del>
                                                            @endif
                                                            <p class="js-unit-price text-danger m-0"
                                                                data-unit-price="{{ $unit_price }}">
                                                                {{ number_format($unit_price, 0, '.', ',') }}đ
                                                            </p>

                                                        </td>
                                                        </td>
                                                        <td>
                                                            <div class="custom-table-action">
                                                                @if ($detailed_product->quantities > 0)
                                                                    <input class="quantities-input" type="number"
                                                                        max="{{ $detailed_product->quantities }}">
                                                                @endif

                                                                <button class="js-add-product btn p-2"
                                                                    @if ($detailed_product->quantities == 0) disabled @endif>
                                                                    <img src="{{ asset('svg/plus.svg') }}"
                                                                        style="width: 18px;" />
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="d-flex justify-content-end my-2">
                                        {{ $detailed_products->render('common.ajax-pagination') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
