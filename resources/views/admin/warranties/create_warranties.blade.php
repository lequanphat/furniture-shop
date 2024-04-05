<div class="modal fade" id="warranty-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

        <!-- Form đây, khi nhấn tạo form, gửi dữ liệu qua file order_api.js, ở hàm có id giống id form -->
        <form id="create-warranty-form" action="#" method="dialog">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Warranty</h5>
                    <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                        aria-label="Close"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row row-cards">

                            <!--order id của warranty-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="orderID" class="form-label">Order number</label>
                                    <select id="orderID" name="orderID" class="form-control form-select">
                                        @foreach ($orders as $order)
                                            <option value="{{ $order->order_id }}">{{ $order->order_id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!--sku của product detail-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_detail_ID" class="form-label">Product detail</label>
                                    <select id="product_detail_ID" name="product_detail_ID"
                                        class="form-control form-select">
                                        @foreach ($all_product_detail as $sku)
                                            <option value="{{ $sku->sku }}">{{ $sku->sku }}-{{ $sku->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_detail_ID_test" class="form-label">Detail of order</label>
                                    <select id="product_detail_ID_test" name="product_detail_ID_test" class="form-control form-select">
                                        @foreach ($warranties as $sku)
                                            <option value="{{ $sku->product_detail->product_id }}">{{ $sku->product_detail->product_id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}


                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input id="start_date" name="start_date" class="form-control" type="date">

                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <input id="description" name="description" type="text" class="form-control"
                                        placeholder="Enter description" value="" required>
                                </div>
                            </div>





                        </div>
                    </div>
                    <div id="create_warranty_response" class="alert ">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn me-auto">Reset</button>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
