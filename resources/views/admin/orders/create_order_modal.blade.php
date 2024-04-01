<div class="modal fade" id="order-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="create-order-form" action="#" method="dialog">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Order</h5>
                    <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                        aria-label="Close"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="receiver_name" class="form-label">Receiver name</label>
                                    <input id="receiver_name" name="receiver_name" type="text" class="form-control"
                                        placeholder="Enter name" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone number</label>
                                    <input id="phone_number" name="phone_number" type="tel" class="form-control"
                                        placeholder="Enter phone number" value="" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Receiver address</label>
                                    <input id="address" name="address" type="text" class="form-control"
                                        placeholder="Enter address" value="" required>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-control form-select">
                                        <option value="0">Unconfirmed</option>
                                        <option value="1">Confirmed</option>
                                        <option value="2">In transit</option>
                                        <option value="3">Delivered</option>
                                        <option value="4">Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Advanced select</label>
                                    <select id="customer_id" name="customer_id" type="text" class="form-select">
                                        <option value="-1" selected>Không
                                        </option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->user_id }}">{{ $customer->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-check">
                                    <input id="paid" name="paid" class="form-check-input" type="checkbox"
                                        checked>
                                    <span class="form-check-label">Paid yet ?</span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div id="create_order_response" class="alert ">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn me-auto">Reset</button>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
