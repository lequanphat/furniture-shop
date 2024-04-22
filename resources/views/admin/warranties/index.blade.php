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
                                <input id="search-warranties" name="search" type="text" class="form-control" placeholder="Search..." autocomplete="off" value="{{ $search }}">
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
                                <input id="search_day_first" name="search_day_first" class="col-6 form-control" type="date"
                                    value="{{ $searchdayfirst }}" title="Start date">
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
                                <option value="oldest_warrant" selected>Oldest created</option>
                                <option value="latest_warrant" >Latest created</option>
                                <option value="longest_warrant" >Longest warrant time</option>
                                <option value="shorted_warrant" >Shortest warrant time</option>
                                <option value="sort_by_order" >Sort by order</option>
                                <option value="sort_by_product" >Sort by product</option>
                            </select>
                        </div>





                        <div class="col-auto">
                            <!--nút thêm-->
                            <!--Điểm đầu đường đi tạo form, nhớ tạo hàm tạo order mới và route cho nó-->
                            <!--nút tạo order mới, dẫn qua file create_order kế bên -->
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
                                        <th>Product</th>
                                        <th>Start day</th>
                                        <th>End day</th>
                                        <th>Description</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id ="warranties-list">
                                    @foreach ($warranties as $warranty)
                                        <tr>
                                            <td>{{ $warranty->warranty_id }}</td>
                                            <td>{{ $warranty->order_id }}</td>
                                            <td>{{ $warranty->sku }}</td>
                                            <td>{{ $warranty->start_date }}</td>
                                            <td>{{ $warranty->end_date }}</td>
                                            <td>{{ $warranty->description }}</td>
                                            <td>{{ $warranty->product_detail->warranty_month}} months</td>
                                            <td>
                                                @if ($warranty->is_active())
                                                <span class="badge bg-green-lt">Still on</span>

                                                @else
                                                <span class="badge bg-red-lt">Not Within</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!--nút sửa-->
                                                <button type="button" class="js-update-order-btn btn  mr-2 px-2 py-1"
                                                    title="Update" data-bs-toggle="modal" data-bs-target="#UpdateWarrantyModal"
                                                    data-warranty-id="{{ $warranty->warranty_id }}"
                                                    data-order-id="{{ $warranty->order_id }}"
                                                    data-sku="{{ $warranty->sku }}"
                                                    data-start-date="{{ $warranty->start_date }}"
                                                    {{-- data-end-date="{{ $warranty->end_date }}" --}}
                                                    data-description="{{ $warranty->description }}"
                                                    >
                                                    <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table><br><br>
                            {{-- <div class="d-flex justify-content-end my-2">{{ $warranties->render('common.pagination') }} --}}
                            <div class="d-flex justify-content-end my-2">{{ $warranties->render('common.ajax-pagination') }}

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
