@extends('layouts.admin')
@section('content')
    <section id="main-content">
        <div class="row">
            <div class="col-lg-6 ">
                <h5>The list of Categories</h5>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-end ">
                    <button id="js-create-category-btn" type="button" class="btn btn-primary mr-2">
                        <span class=" mr-1">CREATE</span>
                        <i class="ti-plus"></i>
                    </button>
                    <button type="button" class="btn btn-primary mr-2">
                        <i class="ti-reload"></i>
                    </button>


                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <span class="d-none d-sm-inline">
                                <a href="#" class="btn">
                                    New view
                                </a>
                            </span>
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#modal-simple">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Create new employee
                            </a>
                            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modal-report" aria-label="Create new report">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="bootstrap-data-table-panel ">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>

                                        <tr>
                                            <th>Categor_id</th>
                                            <th>name</th>
                                            <th>description</th>
                                            <th>index</th>
                                            <th>parent_id</th>
                                            <th> Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="employee-table">
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td>{{ $category->category_id }}</td>

                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    {{ $category->description }}
                                                </td>
                                                <td> {{ $category->index }}</td>
                                                <td>{{ $category->parent_id }}</td>
                                                {{-- temporary value --}}
                                                <td>
                                                    <button type="button"
                                                        class="js-update-category-btn btn btn-warning mr-2 px-2 py-1"
                                                        data-category-id="{{ $category->category_id }}"
                                                        data-name="{{ $category->name }}"
                                                        data-description="{{ $category->description }}"
                                                        data-index="{{ $category->index }}"
                                                        data-parent-id="{{ $category->parent_id }}">

                                                        <i class="ti-pencil-alt"></i>
                                                    </button>

                                                </td>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /# card -->
                </div>
                <!-- /# column -->
            </div>
            <h1>This is categories page</h1>
            @include('admin.categories.create_category')
            @include('admin.categories.update_category')
            @include('admin.components.footer')

    </section>
@endsection
