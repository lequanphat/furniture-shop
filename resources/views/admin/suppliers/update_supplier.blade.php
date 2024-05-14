<div class="modal fade" id="UpdateSupplierModal" tabindex="-1" aria-labelledby="updateBrandTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateSupplierTitle">Update_supplier </h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form goes here -->
                <form id="update-supplier-form" action="#" method="dialog">
                    @csrf
                    <div class="mb-3 row">
                        <input type="text" class="form-control d-none" id="supplier_id" name="supplier_id" readonly>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Phone number</label>
                            <input type="number" class="form-control" id="phone_number" name="phone_number"
                                placeholder="0123123123" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="203 An Dương Vương, phường 01, quận 5, TP.HCM" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                    </div>


                    <div id="update_supplier_response" class="alert d-none">
                    </div>
                    <button type="submit" class="btn btn-primary float-right px-4 ">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
