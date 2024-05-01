@extends('layouts.admin')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        {{ $page }} Management
                    </h2>
                </div>




                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <!--Thanh công cụ-->
                    <div class="row justify-content-end">

                        {{-- thanh search --}}
                        <div class="col-3">
                            <div class="input-icon ">
                                <input id="search-warranties" name="search" type="text" class="form-control"
                                    placeholder="Search..." autocomplete="off" value="{{ $search }}">
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

                        {{-- lọc theo khoảng thời gian --}}
                        <div class="col-4 row ">
                            <div class="col-6">
                                <input id="search_day_first" name="search_day_first" class="col-6 form-control"
                                    type="date" value="{{ $searchdayfirst }}" title="Start date">
                            </div>
                            <div class="col-6">
                                <input id="search_day_last" name="search_day_last" class="col-6 form-control" type="date"
                                    value="{{ $searchdaylast }}" title="End date">
                            </div>

                        </div>

                        {{-- sort theo status --}}
                        <div class="col-2">
                            <select id="status_type" name="status_type" class="form-select" title="Choose type">
                                <option value="all" @if ($statustype == 'all') selected @endif>All status</option>
                                <option value="1" @if ($statustype == '1') selected @endif>Still on</option>
                                <option value="0" @if ($statustype == '0') selected @endif>Not within</option>
                            </select>
                        </div>

                        {{-- sort theo khác --}}
                        <div class="col-2">
                            <select id="sort_by" name="sort_by" class="form-select" title="Sort">
                                <option value="oldest_warrant" @if ($sort == 'oldest_warrant') selected @endif>Oldest
                                    created</option>
                                <option value="latest_warrant" @if ($sort == 'latest_warrant') selected @endif>Latest
                                    created</option>
                                <option value="longest_warrant" @if ($sort == 'longest_warrant') selected @endif>Longest
                                    warrant time</option>
                                <option value="shortest_warrant" @if ($sort == 'shortest_warrant') selected @endif>Shortest
                                    warrant time</option>
                                <option value="sort_by_order" @if ($sort == 'sort_by_order') selected @endif>Sort by
                                    order</option>
                                <option value="sort_by_product" @if ($sort == 'sort_by_product') selected @endif>Sort by
                                    product</option>
                            </select>
                        </div>

                        @can('create order')
                            <div class="col-auto">
                                <a href="#" class="btn btn-primary w-100 btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#warranty-modal">
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
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id ="warranties-list">
                                    @if ($warranties->isEmpty())
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($warranties as $warranty)
                                            <tr>
                                                <td>{{ $warranty->warranty_id }}</td>
                                                <td>{{ $warranty->order_id }}</td>


                                                <td class="text-muted">
                                                    <div>
                                                        <strong>{{ $warranty->order->receiver_name }}</strong>
                                                    </div>
                                                    <div>
                                                        {{ $warranty->order->phone_number }}
                                                    </div>
                                                </td>
                                                <td class="text-muted">
                                                    <div>
                                                        <strong>{{ $warranty->product_detail->name }}</strong>
                                                    </div>
                                                    <div>
                                                        {{ $warranty->product_detail->sku }}
                                                    </div>
                                                </td>

                                                <td>{{ $warranty->start_date }} -> {{ $warranty->end_date }}</td>

                                                <td>
                                                    @if ($warranty->is_active())
                                                        <span class="badge bg-green-lt">Still on</span>
                                                    @else
                                                        <span class="badge bg-red-lt">Not Within</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('warranties.details', $warranty->warranty_id) }}"
                                                        class="btn p-2" title="Warranty Details">
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

                                                    @can('update order')
                                                        <button type="button" class="js-update-order-btn btn  p-2"
                                                            title="Update" data-bs-toggle="modal"
                                                            data-bs-target="#UpdateWarrantyModal"
                                                            data-warranty-id="{{ $warranty->warranty_id }}"
                                                            data-order-id="{{ $warranty->order_id }}"
                                                            data-sku="{{ $warranty->sku }}"
                                                            data-start-date="{{ $warranty->start_date }}"
                                                            {{-- data-end-date="{{ $warranty->end_date }}" --}}
                                                            data-description="{{ $warranty->description }}">
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
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                            {{-- <div class="d-flex justify-content-end my-2">{{ $warranties->render('common.pagination') }} --}}
                            <div class="d-flex justify-content-end my-2">
                                {{ $warranties->render('common.ajax-pagination') }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('admin.warranties.create_warranties')
    @include('admin.warranties.update_warranties')
    @include('admin.components.footer')
    <script src="{{ asset('js/warranty_api.js') }}" defer></script>
@endsection
