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
                        Update Product
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="{{ route('products.index') }}" class="btn">Back</a>
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
                    <form action="{{ route('products.update', $product->product_id) }}" method="POST" class="card">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Product Title</label>
                                        <input id="title" name="title" type="text" class="form-control"
                                            placeholder="High quality plastic tables and chairs"
                                            value="{{ $product->name }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Brand</label>
                                        <select id="brand" name="brand" class="form-control form-select">
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->brand_id }}"
                                                    @if ($brand->brand_id == $product->brand_id) selected @endif>{{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select id="category" name="category" class="form-control form-select">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->category_id }}"
                                                    @if ($category->category_id == $product->category_id) selected @endif>{{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 mb-0">
                                        <label class="form-label">Description</label>
                                        <textarea id="editor" name="description">{{ $product->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary">Save
                                    changes</button></div>
                        </div>

                    </form>
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
