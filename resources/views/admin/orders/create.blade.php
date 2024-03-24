@extends('layouts.admin')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Create Product
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <form id="create-orders-form" action="#" method="POST" class="card">
                        <div class="card-body">
                            <div class="row row-cards">

                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="totalPrice" class="form-label">Total price</label>
                                        <input id="totalPrice" name="totalPrice" type="number" class="form-control"
                                            placeholder="Enter the price money " value="" min="0">
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
                                        <label for="stastus" class="form-label">Status</label>
                                        <input id="status" name="status" type="number" class="form-control"
                                            placeholder="Enter status" value="" maxlength="10" min="0">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="customer" class="form-label">Customer name</label>
                                        <input id="customer" name="customer" type="text" class="form-control"
                                            placeholder="Enter status" value="">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Create Product</button>
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
        CKEDITOR.replace('editor');
    </script>
@endsection
