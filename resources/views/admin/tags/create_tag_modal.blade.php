<!-- Modal -->
<div class="modal modal-blur fade" id="create-tag-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="create-tag-form" action="#" method="dialog" style="width: 60%; margin: 0 auto">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tag name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Chair"
                            required>
                    </div>
                    <div id="create_response" class="alert m-0 d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn me-auto">Reset</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
