<div class="modal fade" id="UpdateOrderDetailModal" tabindex="-1" aria-labelledby="updateOrderDetailTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateOrderDetailTitle">Update_order </h5> <!--id updateOrderDetailTitle sẽ được gửi từ hàm js có id UpdateOrderDetailModal-->
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">

                <!-- Form -->
                <form id="update-order-detail-form" action="#" method="dialog">
                    @csrf
                    <div class="card-body">
                        <div class="row row-cards">

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="orderID" class="form-label">Order id</label>
                                    <input id="orderID" name="orderID" type="number" class="form-control"
                                        value="" readonly>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="productDetailId" class="form-label">Product detail id</label>
                                    <input id="productDetailId" name="productDetailId" class="form-control"
                                        value="" readonly>
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantities - only can update here</label>
                                    <input id="quantity" name="quantity" type="number" class="form-control"
                                        placeholder="Enter quantity" value="" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="unitPrice" class="form-label">Unit price</label>
                                    <input id="unitPrice" name="unitPrice" type="number" class="form-control"
                                        placeholder="Enter unit price" value="" readonly>
                                </div>
                            </div>


                        </div>
                    </div>



                    <div id="update_order_detail_response" class="alert ">
                    </div>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
