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
                        {{$page}} Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="#" class="btn">
                                New view
                            </a>

                        </span>
                        <a href="/admin/orders/create" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new {{$page}}
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
                                        <th>ID</th>
                                        <th>Total Price</th>
                                        <th>Paid</th>
                                        <th>Status</th>
                                        <th>Receiver name</th>
                                        <th>Address</th>
                                        <th>Number</th>
                                        <th>Customer ID</th>
                                        <th>Created by employee</th>
                                    </tr>
                                </thead>
                                <tbody id ="employee-table">
                                    <!--đây là 1 vòng lặp for each trong blade để hiển thị dữ liệu lên bảng
                                    với $orders là dữ liệu được truyền vào từ OrderController(hàm index của nó)
                                    với các loại dữ liệu như order_id chính là các cột trong csdl(vô đó coi viết cho chính xác-->
                                    @foreach ($orders_table as $order)
                                        <tr><!--protected $fillable = ['total_price', 'is_paid', 'status', 'receiver_name', 'address', 'phone_number', 'customer_id', 'created_by'];    //mảng các trường có thể tác động
                                        -->
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->total_price }}</td>
                                            <td>{{ $order->is_paid }}</td>
                                            <td>{{ $order->status }}</td>
                                            <td>{{ $order->receiver_name }}</td>
                                            <td>{{ $order->address }}</td>
                                            <td>{{ $order->phone_number }}</td>
                                            <td>{{ $order->customer_id }}</td>
                                            <td>{{ $order->created_by }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.components.footer')
    </div>
    {{-- Modal --}}
@endsection
