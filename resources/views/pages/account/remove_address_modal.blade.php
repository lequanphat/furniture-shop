<div class="modal fade" id="RemoveAddressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateAddressTitle">Remove Adress </h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form goes here -->
                <form id="remove-address-form" action="#" method="dialog">
                    @csrf
                    <div class="mb-3 row">
                    <input type="text" class="form-control d-none" id="address_id" name="address_id" readonly>
                    <p>Are you sure you want to delete?</p>
                    </div>
                    <div id="remove_address_response" class="alert ">
                    </div>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Delete</button>
                    <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cancel
                        </button>
                </form>
            </div>
        </div>
    </div>
</div>
