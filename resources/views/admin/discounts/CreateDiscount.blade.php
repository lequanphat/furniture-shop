<div class="modal fade" id="discount_create_modal_ui" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Discount </h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                        aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form goes here -->
                <form id="create-discount-form" action="#" method="dialog">
                    @csrf
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Tiltle</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                    </div>

                    <div class="mb-3 mx-2">
                        <label for="percentage" class="form-label">percentages</label>
                        <input type="text" class="form-control" id="percentage" name="percentage" required>
                    </div>
                    <div class="mb-3 mx-2">

                        <label for="amount" class="form-label">amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" required>


                    </div>
                    <div class="mb-3 mx-2">

                        <label for="start_date" class="form-label">start_date</label>
                        <input type="text" class="form-control" id="start_date" name="start_date" required>


                    </div>

                    <div class="mb-3 mx-2">

                        <label for="end_date" class="form-label">start_date</label>
                        <input type="text" class="form-control" id="end_date" name="end_date" required>


                    </div>


                    <div id="create_category_response" class="alert ">
                    </div>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>
