<div class="modal fade" id="CreateAddressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateAddressTitle">Create Adress </h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form goes here -->
                <form id="create-address-form" action="#" method="dialog">
                    @csrf
                    <div class="mb-3 row">
                        <input type="text" class="form-control" id="user_id" name="user_id" readonly>
                   
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="receiver_name" name="receiver_name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                            <label for="phone_number" class="form-label">Phone number</label>
                            <input type="number" class="form-control" id="phone_number" name="phone_number"
                                placeholder="0123123123" required>
                        </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            placeholder="203 An Dương Vương, phường 01, quận 5, TP.HCM" required>      
                    </div>
                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"  value="true" name="is_default" id="is_default">
                                    <label class="form-check-label" for="male">Make this address default</label>
                                </div>
                    <div id="create_address_response" class="alert ">
                    </div>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
