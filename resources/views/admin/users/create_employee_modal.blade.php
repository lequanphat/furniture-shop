<!-- Modal -->
<div class="modal fade" id="createEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Employee</h5>
                <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="modal-body">
                <!-- Form goes here -->
                <form id="create-employee-form" action="#" method="dialog">
                    @csrf
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="mb-3 mx-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                                required>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                                required>
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                    </div>
                    <div class="mb-3 mx-2">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>

                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="birth_date" class="form-label">Birth Date</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">Phone number</label>
                            <input type="number" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                    </div>

                    <div class="mb-3 mx-2">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div id="create_employee_response" class="alert ">
                    </div>
                    <button type="submit" class="btn btn-primary float-right px-4 mx-2">Submit</button>
                    <button type="reset" class="btn btn-close float-right px-4 mx-1">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
