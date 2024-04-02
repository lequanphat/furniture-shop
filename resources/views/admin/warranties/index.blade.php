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
                        {{ $page }} Management
                    </h2>
                </div>


                <form class="input-group col" action="{{ route('warranty.search') }}" method="GET">
                    @if (isset($search))
                        <input name="search" type="text" class="form-control form-control-sm" placeholder="Search by order ID"
                            aria-label="Search" value="{{ $search }}">
                        {{-- <input name="start_date" type="date" class="form-control" > --}}
                        <input name="start_date" type="date" class="form-control" value="{{ $search_date }}">
                    @else
                        <input name="search" type="text" class="form-control form-control-sm" placeholder="Search by order ID"
                            aria-label="Search">
                        <input name="start_date" type="date" class="form-control" placeholder="Choose start date">
                    @endif
                    <button class="btn btn-primary btn-sm" type="submit">
                        Search
                    </button>
                </form>


                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <!--Thanh công cụ-->
                    <div class="row g-2">
                        <div class="col-3">
                            <!--nút thêm-->
                            <!--Điểm đầu đường đi tạo form, nhớ tạo hàm tạo order mới và route cho nó-->
                            <!--nút tạo order mới, dẫn qua file create_order kế bên -->
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#warranty-modal">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Create new {{ $page }}
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id ="employee-table">
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
                            </table>
                            <div class="d-flex justify-content-end my-2">{{ $warranties->render('common.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.warranties.create_warranties')
        @include('admin.warranties.update_warranties')
        @include('admin.components.footer')

    </div>
@endsection
