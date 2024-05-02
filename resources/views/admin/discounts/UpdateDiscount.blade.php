<div class="modal fade" id="modal-discount-update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update discount</h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-deck row-cards">
                        <div class="col-12">
                            <form id="Update-discount-form" action="/admin/discounts/update" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
                                    <div class="row row-cards">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="id" class="form-label"> ID</label>
                                                <input id="discount_id" name="discount_id" type="text"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="brand" class="form-label">Percentage</label>
                                                <input class="form-control" type="number" id="percentage"
                                                    name="percentage" min="0" max="100">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title" class="form-label"> Title</label>
                                                <input id="title" name="title" type="text" class="form-control"
                                                    placeholder="High quality plastic tables and chairs" value="">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="start_date" class="form-label">Start date</label>
                                                <input class="form-control" type="date" id="startdate"
                                                    name="startdate">

                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">End date</label>

                                                <input class="form-control" type="date" id="enddate"
                                                    name="enddate">
                                            </div>
                                        </div>



                                    </div>

                                </div>
                                <div id="update_discount_response" class="alert m-0 d-none mb-3"> </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">Update Discount</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
