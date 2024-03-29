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
                    <form id="update-product-form" action="{{ route('products.update', $product->product_id) }}"
                        method="dialog" class="card" data-id="{{ $product->product_id }}">
                        @csrf
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
                                    <div class="mb-3">
                                        <div class="form-label">Select multiple tags</div>
                                        <select name="tags" type="text" class="form-select" id="select-tags"
                                            value="" multiple>
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->tag_id }}"
                                                    @if (in_array($tag->tag_id, $product->product_tags->pluck('tag_id')->toArray())) @selected(true) @endif>
                                                    {{ $tag->name }}</option>
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
                            <div id="js-response" class="alert d-none">
                            </div>

                            <div class="d-flex justify-content-end"><button type="submit" class="btn btn-primary">Save
                                    changes</button></div>
                        </div>

                    </form>
                </div>
            </div>
            @include('admin.components.footer')
        </div>

        {{-- script --}}
        <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
        <script src="{{ asset('vendor/tom-select/dist/js/tom-select.complete.js') }}"></script>
        <script>
            CKEDITOR.replace('editor');
        </script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function() {
                var el;
                window.TomSelect && (new TomSelect(el = document.getElementById('select-tags'), {
                    plugins: ["remove_button"],
                    copyClassesToDropdown: false,
                    dropdownParent: 'body',
                    controlInput: '<input>',
                    render: {
                        item: function(data, escape) {
                            if (data.customProperties) {
                                return '<div><span class="dropdown-item-indicator">' + data
                                    .customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                        option: function(data, escape) {
                            if (data.customProperties) {
                                return '<div><span class="dropdown-item-indicator">' + data
                                    .customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                    },
                }));
            });
            // @formatter:on
        </script>
    @endsection
