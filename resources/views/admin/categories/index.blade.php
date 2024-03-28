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
                        Category Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">

                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#create-category-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>name</th>
                                        <th>description</th>
                                        <th>index</th>
                                        <th>Parent</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody id="category-table-body">
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->category_id }}</td>

                                            <td>{{ $category->name }}</td>
                                            <td>
                                                {{ $category->description }}
                                            </td>
                                            <td> {{ $category->index }}</td>
                                            <td>
                                                @if (isset($category->parent->category_id))
                                                    {{ $category->parent->category_id . ' - ' . $category->parent->name }}
                                                @else
                                                    Không
                                                @endif
                                            </td>
                                            {{-- temporary value --}}
                                            <td>
                                                <button type="button" class="js-update-category-btn btn  mr-2 px-2 py-1"
                                                    data-bs-toggle="modal" data-bs-target="#update-category-modal"
                                                    data-category-id="{{ $category->category_id }}"
                                                    data-name="{{ $category->name }}"
                                                    data-description="{{ $category->description }}"
                                                    data-index="{{ $category->index }}"
                                                    data-parent-id="{{ $category->parent_id }}">
                                                    <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                </button>
                                                <a class="js-delete-category"
                                                    data-category-id="{{ $category->category_id }}">
                                                    <img src="{{ asset('svg/trash.svg') }}" style="width: 18px;" />
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-end my-2">{{ $categories->render('common.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.categories.create_category')
        @include('admin.categories.update_category')
        @include('admin.components.error_delete_modal')
        @include('admin.components.footer')
    </div>
@endsection
