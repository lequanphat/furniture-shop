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
                        Update Detailed Product
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="{{ route('products.details', $detailed_product->product_id) }}" class="btn">Back</a>
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
                    <form id="update-detailed-product-form"
                        action="{{ route('products.update_detailed_product', ['product_id' => $detailed_product->product_id, 'sku' => $detailed_product->sku]) }}"
                        method="POST" class="card">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">SKU</label>
                                        <input id="sku" name="sku" type="text" class="form-control"
                                            value="{{ $detailed_product->sku }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Detailed Name</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            value="{{ $detailed_product->name }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="coder" class="form-label">Color</label>
                                        <input id="color" name="color" type="color"
                                            class="form-control form-control-color" value="{{ $detailed_product->color }}"
                                            style="width: 100%">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="size" class="form-label">Size</label>
                                        <input id="size" name="size" type="text" class="form-control"
                                            value="{{ $detailed_product->size }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="original_price" class="form-label">Original Price</label>
                                        <input id="original_price" name="original_price" type="number" class="form-control"
                                            value="{{ $detailed_product->original_price }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="warranty_month" class="form-label">Warranty Month</label>
                                        <input id="warranty_month" name="warranty_month" type="text" class="form-control"
                                            value="{{ $detailed_product->warranty_month }}">
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
                                                <input class="d-none" type="file" id="image-picker" accept="image/*"
                                                    multiple>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="preview-list" class="row g-2 g-md-3">
                                        @foreach ($detailed_product->images as $image)
                                            <div class="col-md-3 col-sm-4 position-relative">
                                                <a data-fslightbox="gallery" href="#">
                                                    <div class="img-responsive img-responsive-1x1 rounded-3 border"
                                                        style="background-image: url({{ asset('storage/' . $image->url) }})">
                                                    </div>
                                                </a>

                                                <button type="button"
                                                    class="js-remove-image bg-white btn-close position-absolute"
                                                    style="top: 3%; right: 5%;"></button>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 mb-0">
                                        <label class="form-label">Detailed description</label>
                                        <textarea id="editor" name="description">{{ $detailed_product->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="js-error" class="alert alert-danger d-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
