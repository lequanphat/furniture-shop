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
                        Brand Management
                    </h2>
                </div>
                <!-- Search bar-->
                <form class="input-group col" action="{{ route('brands.search') }}" method="GET">
                    @if (isset($search))
                        <input name="search" type="text" class="form-control form-control-sm" placeholder="Search..."
                            aria-label="Search" value="{{ $search }}">
                    @else
                        <input name="search" type="text" class="form-control form-control-sm" placeholder="Search..."
                            aria-label="Search">
                    @endif
                    <button class="btn btn-primary btn-sm" type="submit">
                        Search
                    </button>
                </form>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#brand-modal">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new brand
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
                                        <th>Brand_id</th>
                                        <th>name</th>
                                        <th>description</th>
                                        <th>index</th>
                                        <th> Action</th>

                                    </tr>
                                </thead>
                                <tbody id="employee-table">
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td>{{ $brand->brand_id }}</td>

                                            <td>{{ $brand->name }}</td>
                                            <td>
                                                {{ $brand->description }}
                                            </td>
                                            <td> {{ $brand->index }}</td>
                                            <td>
                                                <button type="button" class="js-update-brand-btn btn  mr-2 px-2 py-1"
                                                    data-bs-toggle="modal" data-bs-target="#UpdateBrandModal"
                                                    data-brand-id="{{ $brand->brand_id }}" data-name="{{ $brand->name }}"
                                                    data-description="{{ $brand->description }}"
                                                    data-index="{{ $brand->index }}"
                                                    data-parent-id="{{ $brand->parent_id }}">
                                                    <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                </button>

                                            </td>
                                    @endforeach

                                </tbody>
                            </table>
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-end my-2">{{ $brands->render('common.pagination') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.brands.create_brand')
        @include('admin.brands.update_brand')
        @include('admin.components.footer')
    </div>
    {{-- Script --}}
    <script src="{{ asset('js/brand_api.js') }}" defer></script>
@endsection
