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
                        Supplier Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <div class="input-icon ">
                            <input id="search-supplier-input" type="text" value="{{ $search }}" class="form-control"
                                placeholder="Search…">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </span>
                        </div>
                        @can('create supplier')
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
                                Create new supplier
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#modal-simple" class="btn btn-primary d-sm-none btn-icon"
                                aria-label="Create new report">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </a>
                        @endcan


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
                                        <th>Supplier_id</th>
                                        <th>name</th>
                                        <th>description</th>
                                        <th>address</th>
                                        <th>phone</th>
                                        <th> Action</th>

                                    </tr>
                                </thead>
                                <tbody id="supplier-table">
                                    @if ($suppliers->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td>{{ $supplier->supplier_id }}</td>

                                                <td>{{ $supplier->name }} @if ($supplier->created_at->diffInDays() < 7)
                                                        <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $supplier->description }}
                                                </td>
                                                <td> {{ $supplier->address }}</td>
                                                <td>{{ $supplier->phone_number }}</td>
                                                {{-- temporary value --}}
                                                <td>
                                                    @can('update supplier')
                                                        <button type="button" class="js-update-category-btn btn  p-2"
                                                            data-bs-toggle="modal" data-bs-target="#UpdateSupplierModal"
                                                            data-supplier-id="{{ $supplier->supplier_id }}"
                                                            data-name="{{ $supplier->name }}"
                                                            data-description="{{ $supplier->description }}"
                                                            data-address="{{ $supplier->address }}"
                                                            data-phone-number="{{ $supplier->phone_number }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                                <path d="M13.5 6.5l4 4" />
                                                            </svg>
                                                        </button>
                                                    @endcan
                                                    @can('delete supplier')
                                                        <button data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"
                                                            data-supplier-id="{{ $supplier->supplier_id }}" class="btn p-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </button>
                                                    @endcan
                                                </td>
                                        @endforeach
                                    @endif


                                </tbody>
                            </table>
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-end my-2">
                                {{ $suppliers->render('common.ajax-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.suppliers.create_supplier')
        @include('admin.suppliers.update_supplier')
        @include('admin.components.footer')
        @include('admin.components.delete_confirm_modal')
        @include('admin.components.error_delete_modal')
        @include('admin.brands.success_notify_modal')
    </div>
    {{-- Script --}}
    <script src="{{ asset('js/supplier_api.js') }}" defer></script>
@endsection
