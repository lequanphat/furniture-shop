<div class="modal fade" id="brand-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Brand </h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form goes here -->
                <form id="create-brand-form" action="#" method="dialog">
                    @csrf
                    <div class="mb-3 mx-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3 mx-2">

                    <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3 mx-2">
                        <label for="index" class="form-label">Index</label>
                        <input type="text" class="form-control" id="index" name="index" required>
                    </div>

                    <div id="create_brand_response" class="alert ">
                    </div>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>
