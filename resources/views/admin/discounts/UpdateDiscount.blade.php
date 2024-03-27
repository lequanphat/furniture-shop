<div class="modal fade" id="modal-discount-update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content "style="max-width: fit-content">

            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <!-- Page pre-title -->
                            <div class="page-pretitle">
                                Overview
                            </div>
                            <h2 class="page-title">
                                Update Discount

                            </h2>
                        </div>
                    </div>
                </div>
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
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label for="title" class="form-label"> Title</label>
                                                <input id="title" name="title" type="text" class="form-control"
                                                    placeholder="High quality plastic tables and chairs" value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label for="amount" class="form-label">amount</label>
                                                <input id="amount" name="amount" class="form-control"
                                                    type="text">


                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label for="active" class="form-label">is active</label>
                                                <select id="active" name="active" class="form-control form-select">
                                                    <option value="1"> On</option>
                                                    <option value="2"> Off</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label for="start_date" class="form-label">start Date</label>

                                                <input class="form-control" type="date" id="startdate"
                                                    name="startdate">

                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">end Date</label>

                                                <input class="form-control" type="date" id="enddate"
                                                    name="enddate">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label for="brand" class="form-label">Percentage</label>
                                                <input class="form-control" type="number" id="percentage"
                                                    name="percentage" min="0" max="100">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label for="id" class="form-label"> ID</label>
                                                <input id="discount_id" name="discount_id" type="text"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3 mb-0">
                                                <label class="form-label">Description</label>
                                                <textarea id="update_editor" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">Update Discount</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @include('admin.components.footer')

            </div>
            {{-- Modal --}}
            <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
            <script>
                CKEDITOR.replace('update_editor');
            </script>
            {{-- @endsection --}}
        </div>
    </div>
</div>
