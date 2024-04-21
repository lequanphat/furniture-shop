<!-- Modal -->
<div class="modal modal-blur fade" id="brand-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="create-brand-form" action="#" method="dialog">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <div class="col-12 mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Hemera Sofa" required>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Hemera Sofa, The brand from Japan" required>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="index" class="form-label">Index</label>
                            <input type="number" class="form-control" id="index" name="index" placeholder="1"
                                required>
                        </div>
                    </div>

                    <div id="create_brand_response" class="alert m-0 d-none"></div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn me-auto">Reset</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
