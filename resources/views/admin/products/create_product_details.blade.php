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
                        Create Product Details
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="{{ route('products.details', $product->product_id) }}" class="btn">Back</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <form id="create-detailed-product-form" action="#" method="POST" class="card">
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Detailed Name</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            placeholder="High quality plastic chairs - Blue - Small" value="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="coder" class="form-label">Color</label>
                                        <input id="color" name="color" type="color"
                                            class="form-control form-control-color" value="#206bc4"
                                            title="Choose your color">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="size" class="form-label">Size</label>
                                        <input id="size" name="size" type="text" class="form-control"
                                            placeholder="255cm x 255cm x 125cm" value="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Upload images</label>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-center"
                                                style="width: 80px; height: 80px;">
                                                <label for="image-picker"
                                                    class="d-flex align-items-center justify-content-center rounded-circle border"
                                                    style="width: 100%; height: 100%; background-color: #f8f9fa; cursor: pointer; border-style: dashed;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="50"
                                                        height="50" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 5l0 14" />
                                                        <path d="M5 12l14 0" />
                                                    </svg>
                                                </label>
                                                <input class="d-none" type="file" id="image-picker" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="preview-list" class="row g-2 g-md-3">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 mb-0">
                                        <label class="form-label">Detailed description</label>
                                        <textarea id="editor" name="description"></textarea>
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
