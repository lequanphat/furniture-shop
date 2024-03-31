<div class="modal fade" id="order-detail-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add order detail</h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">


                <!-- Form đây, khi nhấn tạo form, gửi dữ liệu qua file order_api.js, ở hàm có id giống id form -->
                <form id="create-detail-order-form" action="#" method="dialog">
                    @csrf
                    <div class="card-body">
                        <div class="row row-cards">

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="orderID" class="form-label">Order id</label>
                                    <input id="orderID" name="orderID" type="number" class="form-control"
                                        placeholder="" value="{{ $order->order_id }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="productDetailId" class="form-label">Product detail id</label>
                                    <select id="productDetailId" name="productDetailId" class="form-control form-select">
                                        @foreach ($all_product_detail as $product_detail)
                                            <option value="{{ $product_detail->sku }}">{{ $product_detail->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantities</label>
                                    <input id="quantity" name="quantity" type="number" class="form-control"
                                        placeholder="Enter quantity" value="" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="unitPrice" class="form-label">Unit price</label>
                                    <input id="unitPrice" name="unitPrice" type="number" class="form-control"
                                        placeholder="Enter unit price" value="" required>
                                </div>
                            </div>




                        </div>
                    </div>



                    <div id="create_order_detail_response" class="alert "></div>

                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Add</button>

                </form>
            </div>
        </div>
    </div>
</div>
