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

                        <!--Điểm đầu đường đi tạo form, nhớ tạo hàm tạo order mới và route cho nó-->
                        <!--nút tạo order mới, dẫn qua file create_order kế bên -->
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#order-modal">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new {{$page}}
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#" aria-label="Create new report">
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
                                        <th>ID</th>
                                        <th>Total Price</th>
                                        <th>Paid</th>
                                        <th>Status</th>
                                        <th>Receiver name</th>
                                        <th>Address</th>
                                        <th>Number</th>
                                        <th>Customer ID</th>
                                        <th>Created by employee</th>
                                        <th>Action</th>
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
                                            <td> <!--nút sửa
                                                    id UpdateOrderModal có 2 liên quan:
                                                        1/Nó mở form update order lên
                                                        2/Nó truyền dữ liệu data dưới đây qua 1 hàm js có cùng id để show dữ liệu lên cái form-->
                                                <button type="button" class="js-update-order-btn btn  mr-2 px-2 py-1" title="Update"
                                                    data-bs-toggle="modal" data-bs-target="#UpdateOrderModal"
                                                    data-order-id="{{ $order->order_id }}"
                                                    data-total-price="{{ $order->total_price}}"
                                                    data-is-paid="{{ $order->is_paid }}"
                                                    data-status="{{ $order->status }}"
                                                    data-receiver-name="{{ $order->receiver_name }}"
                                                    data-address="{{ $order->address }}"
                                                    data-phone-number="{{ $order->phone_number }}"
                                                    data-customer-id="{{ $order->customer_id }}"
                                                    data-created-by="{{ $order->created_by }}">
                                                    <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--Phân trang-->
                            <div class="d-flex justify-content-end my-2">{{ $orders_table->render('common.pagination') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.orders.create_order')
        @include('admin.orders.update_order')
        @include('admin.components.footer')

        <!-- Tổng quát      trang chính ở đây là trang index.blade.php
        Với thêm, ta làm:
        1/Tạo hàm thêm ở controller và tạo route của nó ở route/web.php (xem order_create)
        2/Tạo form thêm (nhớ include nó ở trang chính), Khi nhấn nút thêm ở trang chính, chuyển qua form thêm (xem file ) (createorder.blade.php)
        3/Tạo file js ở public/js chứa hàm xử lý, nhớ cho file js vào views/admin/components/link-script.blade.php (order.php hàm có id #create-order-form)
        4/Sau khi nhập đủ thông tin, nhấn nút thì truyền dữ liệu qua hàm có chung id ở file js
        5/file js sẽ truyền dữ liệu sang hàm bên controller xử lý
        6/controller return kết quả về js, js hiển thị qua file form

        Với sửa, ta làm:
        1/Tạo hàm sửa ở controller và tạo route của nó ở route/web.php (xem order_update)
        2/Thêm vào nút sửa ở dòng dữ liệu trên trang chính và lưu thêm dữ liệu ở dòng đó vào nút (xem button có data-bs-target="#UpdateOrderModal")
        3/Tạo form sửa, div chứa form có id UpdateOrderModal và còn form thì có id update-order-form (update_order.blade.php)
        4/Tạo hàm có id UpdateOrderModal ở js để hiển thị dữ liệu ở dòng đó vào form khi bấm sửa
        5/Tạo hàm sửa dữ liệu ở js có id=update-order-form để khi nhấn nút update trên form thì gửi dữ liệu về js
        6/js truyền dữ liệu qua hàm sửa ở controller thông qua route
        7/controller return kết quả về js, js hiển thị qua file form
        -->
    </div>
@endsection
