{{-- @extends('layouts.admin') --}}
{{-- @section('content') --}}

<div class="modal fade" id="modal-discount-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create new discount</h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-deck row-cards">
                        <div class="col-12">
                            <form id="create-discount-form" action="/admin/discounts/create" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row row-cards">
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label for="title" class="form-label"> Title</label>
                                                <input id="title" name="title" type="text" class="form-control"
                                                    placeholder="Enter discount title..." value="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label for="brand" class="form-label">Percentage</label>
                                                <input class="form-control" type="number" id="percentage"
                                                    name="percentage" min="0" max="100">
                                            </div>
                                        </div>



                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label for="start_date" class="form-label">Start date</label>

                                                <input class="form-control" type="date" id="startdate"
                                                    name="startdate">

                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">End date</label>

                                                <input class="form-control" type="date" id="enddate"
                                                    name="enddate">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-label">Active</div>
                                            <label class="form-check form-switch form-switch-lg">
                                                <input name="is_active" class="form-check-input" type="checkbox">
                                                <span class="form-check-label form-check-label-on">Active</span>
                                                <span class="form-check-label form-check-label-off">Unactive</span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div id="create_discount_response" class="alert m-0 d-none mb-3"> </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">Create Discount</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
