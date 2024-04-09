<!-- Modal -->
<div class="modal modal-blur fade" id="create-role-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form id="create-role-form" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Create New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3 row">
                    <div class="col-md-12">
                        <label for="role_name" class="form-label">Role name</label>
                        <input type="text" class="form-control" id="role_name" name="role_name"
                            placeholder="Administrators" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Permission</label>
                    </div>
                    <div class="col-md-2 text-center">
                        <label for="" class="form-label">Read</label>
                    </div>
                    <div class="col-md-2 text-center">
                        <label for="" class="form-label">Create</label>
                    </div>
                    <div class="col-md-2 text-center">
                        <label for="" class="form-label">Update</label>
                    </div>
                    <div class="col-md-2 text-center">
                        <label for="" class="form-label">Delete</label>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">User</label>
                    </div>
                    @for ($i = 0; $i < 4; $i++)
                        @php
                            $permission = $permissions->skip($i)->first();
                        @endphp
                        <div class="col-md-2 text-center">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}">
                        </div>
                    @endfor

                </div>

                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Categories</label>
                    </div>
                    @for ($i = 4; $i < 8; $i++)
                        @php
                            $permission = $permissions->skip($i)->first();
                        @endphp
                        <div class="col-md-2 text-center">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}">
                        </div>
                    @endfor
                </div>

                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Brands</label>
                    </div>
                    @for ($i = 8; $i < 12; $i++)
                        @php
                            $permission = $permissions->skip($i)->first();
                        @endphp
                        <div class="col-md-2 text-center">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}">
                        </div>
                    @endfor
                </div>

                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Colors & Tags</label>
                    </div>
                    @for ($i = 12; $i < 16; $i++)
                        @php
                            $permission = $permissions->skip($i)->first();
                        @endphp
                        <div class="col-md-2 text-center">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}">
                        </div>
                    @endfor
                </div>

                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Products</label>
                    </div>
                    @for ($i = 16; $i < 20; $i++)
                        @php
                            $permission = $permissions->skip($i)->first();
                        @endphp
                        <div class="col-md-2 text-center">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}">
                        </div>
                    @endfor
                </div>


                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Discounts</label>
                    </div>
                    @for ($i = 20; $i < 24; $i++)
                        @php
                            $permission = $permissions->skip($i)->first();
                        @endphp
                        <div class="col-md-2 text-center">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}">
                        </div>
                    @endfor
                </div>


                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Orders</label>
                    </div>
                    @for ($i = 24; $i < 28; $i++)
                        @php
                            $permission = $permissions->skip($i)->first();
                        @endphp
                        <div class="col-md-2 text-center">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}">
                        </div>
                    @endfor
                </div>

                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Receipts</label>
                    </div>
                    @for ($i = 28; $i < 32; $i++)
                        @php
                            $permission = $permissions->skip($i)->first();
                        @endphp
                        <div class="col-md-2 text-center">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}">
                        </div>
                    @endfor
                </div>


                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Suppliers</label>
                    </div>
                    @for ($i = 32; $i < 36; $i++)
                        @php
                            $permission = $permissions->skip($i)->first();
                        @endphp
                        <div class="col-md-2 text-center">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}">
                        </div>
                    @endfor
                </div>

                <div class="mb-3 row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Permissions</label>
                    </div>
                    @for ($i = 36; $i < 40; $i++)
                        @php
                            $permission = $permissions->skip($i)->first();
                        @endphp
                        <div class="col-md-2 text-center">
                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}">
                        </div>
                    @endfor
                </div>

                <div id="create_role_response" class="alert m-0 d-none"></div>

            </div>
            <div class="modal-footer">
                <button type="reset" class="btn me-auto" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
