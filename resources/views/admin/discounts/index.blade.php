@extends('layouts.admin')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Discount Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="row justify-content-end">
                        <div class="col-4">
                            <div class="input-icon ">
                                <input id="search" type="text" class="form-control" placeholder="Search…"
                                    value="{{ $search }}">
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
                        </div>

                        <div class="col-2">
                            <select id="status_type" name="type" class="form-select" title="Choose type">
                                <option value="all" @if ($type == 'all') selected @endif>All</option>
                                <option value="active" @if ($type == 'active') selected @endif>Active</option>
                                <option value="blocked" @if ($type == 'blocked') selected @endif>Blocked
                                </option>
                            </select>

                        </div>
                        <div class="col-2">
                            <select id="status" name="status" class="form-select" title="Choose type">
                                <option value="all" @if ($status == 'all') selected @endif>All</option>
                                <option value="indate" @if ($status == 'indate') selected @endif>In Date</option>
                                <option value="outdate" @if ($status == 'outdate') selected @endif>Out Date</option>
                            </select>

                        </div>

                        @can('create discount')
                            <div class="col-auto">
                                <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                    data-bs-target="#modal-discount-create">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Create new Discount
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#modal-discount-create"
                                    class="btn btn-primary d-sm-none btn-icon" aria-label="Create new report">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                </a>
                            </div>
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
                            <table id="myTable" class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Discount_id</th>
                                        <th>Title</th>
                                        <th>percentage</th>
                                        <th>start date</th>
                                        <th>end date</th>
                                        <th>active</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody id="discounts-table">
                                    @foreach ($discounts as $discount)
                                        <tr>
                                            <td>{{ $discount->discount_id }}</td>
                                            <td>{{ $discount->title }}</td>
                                            <td>
                                                {{ $discount->percentage }}%
                                            </td>
                                            <td>{{ $discount->start_date }}</td>
                                            <td>{{ $discount->end_date }}</td>
                                            <td>
                                                @if ($discount->is_active)
                                                    <span class="badge bg-success me-1"></span> Active
                                                @else
                                                    <span class="badge bg-danger me-1"></span> Blocked
                                                @endif
                                            </td>

                                            {{-- temporary value --}}
                                            <td>
                                                <a href="{{ route('discount.detail', $discount->discount_id) }}"
                                                    data-discount-id="{{ $discount->discount_id }}" class="btn p-2">
                                                    {{--                                                    <a class="btn p-2" data-discount-id="{{ $discount->discount_id }}" --}}
                                                    {{--                                                     > --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>
                                                </a>
                                                @can('update discount')
                                                    <button class="btn p-2 d-none d-sm-inline-block  js-update-discount-btn"
                                                        data-bs-toggle="modal" data-bs-target="#modal-discount-update"
                                                        data-discount-id="{{ $discount->discount_id }}"
                                                        data-title="{{ $discount->title }}"
                                                        data-description="{{ $discount->description }}"
                                                        data-amount="{{ $discount->amount }}"
                                                        data-start-date="{{ $discount->start_date }}"
                                                        data-end-date="{{ $discount->end_date }}"
                                                        data-is-active="{{ $discount->is_active }}"
                                                        data-percentage="{{ $discount->percentage }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                            <path d="M13.5 6.5l4 4" />
                                                        </svg>
                                                    </button>
                                                @endcan

                                                @can('delete discount')
                                                    @if ($discount->is_active)
                                                        <button data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"
                                                            data-discount-id="{{ $discount->discount_id }}" class="btn p-2">
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
                                                    @else
                                                        <a href="#" class="btn p-2" data-bs-toggle="modal"
                                                            data-bs-target="#restore-confirm-modal"
                                                            data-discount-id="{{ $discount->discount_id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-key">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                                                                <path d="M15 9h.01" />
                                                            </svg>
                                                        </a>
                                                    @endif
                                                @endcan

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            {{-- Pagination --}}

                        </div>

                        <div class=" d-flex justify-content-end my-2">
                            {{ $discounts->render('common.pagination') }}
                        </div>


                    </div>
                </div>
            </div>
        </div>
        </td>';


        @include('admin.discounts.CreateDiscount')
        @include('admin.discounts.UpdateDiscount')
        @include('admin.components.footer')
        @include('admin.components.delete_confirm_modal')
        @include('admin.discounts.restore_confirm_modal')


    </div>
    </div>
    {{-- Script --}}
    <script src="{{ asset('js/discount_api.js') }}" defer></script>
@endsection
