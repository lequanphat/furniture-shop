<div class="modal fade" id="create-receipt-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="create-receipts-form" class="w-full" action="#" method="dialog">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Receipt</h5>
                    <button type="button" class="btn-close border-none bg-transparent" data-bs-dismiss="modal"
                        aria-label="Close"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-12">
                                <label for="" class="form-label">Supplier</label>
                                <select id="supplier_id" name="supplier_id" type="text" class="form-select">
                                    <option value="-1" selected>Không
                                    </option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier_id }}">{{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="create_receipts_response" class="alert d-none">
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
