<div class="modal fade" id="UpdateCategoryModal" tabindex="-1" aria-labelledby="updateCateTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCateTitle">Update_Category </h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form goes here -->
                <form id="update-category-form" action="#" method="dialog">
                    @csrf
                    <input type="text" class="form-control" id="category_id" name="category_id" required>
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
                    <div class="mb-3 mx-2">

                        <label for="parent_id" class="form-label">Parent Id</label>
                        <input type="text" class="form-control" id="parent_id" name="parent_id" required>


                    </div>

                    <div id="update_category_response" class="alert ">
                    </div>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
