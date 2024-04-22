<div class="modal fade" id="receipts-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="create-order-form" action="#" method="dialog">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Receipts</h5>
                    <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="receiving_report_id" class="form-label">Receiving Report ID</label>
                                    <input id="receiving_report_id" name="receiving_report_id" type="text" class="form-control"
                                           placeholder="Enter name" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label"> total Price</label>
                                    <input id="total_price" name="total_price" type="tel" class="form-control"
                                           placeholder="" value="total_price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="createdBy" class="form-label"> Created By</label>
                                    <input id="createdBy" name="createdBy" type="text" class="form-control"
                                         value="" required>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Supplier ID</label>
                                    <select id="supplier_id" name="supplier_id" type="text" class="form-select">
                                        <option value="-1" selected>Không
                                        </option>
                                        @foreach ($supplier as $spl)
                                            <option value="{{ $spl->supplier_id }}">{{ $spl->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div id="create_order_response" class="alert ">
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
