<div class="modal fade" id="order-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Order</h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">


                <!-- Form đây, khi nhấn tạo form, gửi dữ liệu qua file order_api.js, ở hàm có id giống id form -->
                <form id="create-order-form" action="#" method="dialog">
                    @csrf
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="totalPrice" class="form-label">Total price</label>
                                    <input id="totalPrice" name="totalPrice" type="number" class="form-control"
                                        placeholder="Enter the price money " value="" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="paid" class="form-label">Paid yet ?</label>
                                    <select id="paid" name="paid" class="form-control form-select">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input id="status" name="status" type="number" class="form-control"
                                        placeholder="Enter status" value="" maxlength="10" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="receiver_name" class="form-label">Receiver name</label>
                                    <input id="receiver_name" name="receiver_name" type="text" class="form-control"
                                        placeholder="Enter name" value="" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Receiver address</label>
                                    <input id="address" name="address" type="text" class="form-control"
                                        placeholder="Enter address" value="" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Receiver phone number</label>
                                    <input id="phone_number" name="phone_number" type="tel" class="form-control"
                                        placeholder="Enter phone number" value="" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Customer</label>
                                    <select id="customer_id" name="customer_id" class="form-control form-select">
                                        @foreach ($customer_and_employee as $customer_id)
                                            <option value="{{ $customer_id->user_id }}">{{ $customer_id->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="employee_id" class="form-label">Created by</label>
                                    <select id="employee_id" name="employee_id" class="form-control form-select">
                                        @foreach ($customer_and_employee as $employee_id)
                                            <option value="{{ $employee_id->user_id }}">{{ $employee_id->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div id="create_order_response" class="alert ">
                    </div>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Create!!!</button>

                </form>
            </div>
        </div>
    </div>
</div>
