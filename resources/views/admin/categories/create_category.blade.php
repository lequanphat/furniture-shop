<div class="modal fade" id="create-category-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Form goes here -->
        <form id="create-category-form" action="/admin/discounts/create" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Category </h5>
                    <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="index" class="form-label">Index</label>
                            <input type="text" class="form-control" id="index" name="index" required>

                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select id="parent_id" name="parent_id" class="form-control form-select">
                                <option value="-1">Không</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>

                    <div id="create_category_response" class="alert d-none">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn me-auto">Reset</button>
                    <button type="submit" class="btn btn-primary float-right px-4">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
