<div class="modal fade" id="UpdateBrandModal" tabindex="-1" aria-labelledby="updateBrandTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBrandTitle">Update_brand </h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form goes here -->
                <form id="update-brand-form" action="#" method="dialog">
                    @csrf
                    <input type="text" class="form-control" id="brand_id" name="brand_id" readonly>
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                    </div>

                    <div class="mb-3 mx-2">
                        <label for="index" class="form-label">Index</label>
                        <input type="text" class="form-control" id="index" name="index" required>
                    </div>
                    <div id="update_brand_response" class="alert ">
                    </div>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
