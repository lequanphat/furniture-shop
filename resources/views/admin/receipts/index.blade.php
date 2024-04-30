@extends('layouts.admin')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Receipts Management
                    </h2>
                </div>
                <!-- Page actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="row justify-content-end">
                        <div class="col-4">
                            <div class="input-icon ">
                                <input id="search-receipts" name="search" type="text" value="{{ $search }}"
                                    class="form-control" placeholder="Search…" autocomplete="off">
                                <span class="input-icon-addon">
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

                        <div class="col-3">
                            <select id="type-receipts" name="supplier" class="form-select" title="Choose type">
                                <option value="all" @if ($type == 'all') selected @endif>All</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_id }}"
                                        @if ($type == $supplier->supplier_id) selected @endif>{{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <select id="sort-receipts" name="sort" class="form-select" title="Sort">
                                <option value="latest" @if ($sort == 'latest' || $sort == null) selected @endif>Latest Receipts
                                </option>
                                <option value="oldest" @if ($sort == 'oldest') selected @endif>Oldest Receipts
                                </option>
                                <option value="price_asc" @if ($sort == 'price_asc') selected @endif>Price ascending
                                </option>
                                <option value="price_desc" @if ($sort == 'price_desc') selected @endif>Price
                                    descending</option>
                            </select>
                        </div>
                        @can('create receipt')
                            <div class="col-auto">
                                <a href="#" class="btn btn-primary w-100 btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#create-receipt-modal" title="Create new order">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon " width="24" height="24"
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
                <!-- End Page actions -->
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
                                        <th>Supplier Id</th>
                                        <th>Date time</th>
                                        <th>Total Price</th>
                                        <th>created By</th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody id="receipts-table">
                                    @if ($receipts->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($receipts as $receipt)
                                            <tr>
                                                <td>{{ $receipt->receiving_report_id }}</td>
                                                </td>
                                                <td class="text-muted">
                                                    <div>
                                                        <strong>{{ $receipt->supplier->name }}</strong> |
                                                        {{ $receipt->supplier->phone_number }}
                                                    </div>
                                                    <div>
                                                        {{ $receipt->supplier->address }}
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ Carbon::parse($receipt->created_at)->diffForHumans() }}
                                                </td>
                                                <td class="text-danger">
                                                    {{ number_format($receipt->total_price, 0, '.', ',') }}đ

                                                <td class="text-muted">
                                                    <div>
                                                        <strong>{{ $receipt->employee->first_name }}
                                                            {{ $receipt->employee->last_name }}</strong> |
                                                        {{ $receipt->employee->default_address->phone_number }}
                                                    </div>
                                                    <div>
                                                        {{ $receipt->employee->default_address->address }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('receipts.details', $receipt->receiving_report_id) }}"
                                                        class="btn p-2" title="Details">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path
                                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="js-receipts-pagination d-flex justify-content-end my-2">
                                {{ $receipts->render('common.ajax-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @include('admin.components.footer')
    </div>
    {{-- Modal --}}
    @include('admin.receipts.create_receipt_modal')
    {{-- Script --}}
    <script src="{{ asset('js/receipts_api.js') }}" defer></script>
@endsection
