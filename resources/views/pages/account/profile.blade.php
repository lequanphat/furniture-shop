@extends('layouts.app')
@section('content')
    {{-- Mini cart --}}
    @include('components.mini-cart')
    {{-- Head banner --}}
    @include('components.head-banner')
    
    <!-- my account wrapper start -->
    <div class="my-account-wrapper pb-100 pt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#account-info" data-bs-toggle="tab">Dashboard</a>
                                    <a href="#address-edit" data-bs-toggle="tab">Address</a>
                                    <a href="#orders" data-bs-toggle="tab">Orders</a>
                                    <a href="/logout" class="text-danger">Logout</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Orders</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Aug 22, 2022</td>
                                                            <td>Pending</td>
                                                            <td>$3000</td>
                                                            <td><a href="cart.html" class="check-btn sqr-btn ">View</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>July 22, 2022</td>
                                                            <td>Approved</td>
                                                            <td>$200</td>
                                                            <td><a href="cart.html" class="check-btn sqr-btn ">View</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>June 12, 2017</td>
                                                            <td>On Hold</td>
                                                            <td>$990</td>
                                                            <td><a href="cart.html" class="check-btn sqr-btn ">View</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                        <div class="myaccount-content">
                                        <button class="check-btn sqr-btn " 
                                            data-bs-toggle="modal" data-bs-target="#CreateAddressModal" 
                                                    data-user-id="{{$user->user_id}}">
                                            <i class="fa fa-plus"></i> Create
                                                Address</button>
                                            <h3>Billing Address</h3>
                                            @foreach($address_cards as $address)
                                            <address>
                                                @if($address->is_default)
                                                <p> Default address<p>
                                                @endif
                                                <p><strong>{{$address->receiver_name}}</strong></p>
                                                <p>{{$address->address}}</p>
                                                <p>{{$address->phone_number}}</p>
                                            </address>
                                            <button href="#" class="check-btn sqr-btn " 
                                            data-bs-toggle="modal" data-bs-target="#UpdateAddressModal" 
                                                    data-address-id="{{$address->address_id}}"
                                                    data-receiver-name="{{ $address->receiver_name }}"
                                                    data-address="{{ $address->address }}"
                                                    data-phone-number="{{ $address->phone_number }}"
                                                    data-is-default="{{ $address->is_default ? 'true' : 'false' }}">
                                            <i class="fa fa-edit"></i> Edit
                                                Address</button>
                                                <h3></h3>
                                            @endforeach
                                        </div>
                                        
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Account Details</h3>
                                            <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" id="enable-edit-profile-customer">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Edit profile
                        </a>
                    </div>
                </div>
                                            <div class="account-details-form">
                                            <form id="update-profile-customer-form" action="#">
                    @csrf
                    <div class="col-12">
<div class="mb-3 row">
    <div class="col-md-6">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name"
            placeholder="Cristiano" value="{{ $user->first_name }}" readonly>
    </div>
    <div class="col-md-6">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name"
            placeholder="Ronaldo" value="{{ $user->last_name }}" readonly>
    </div>
</div>
<div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male"
                                        value="male" readonly
                                        @if ($user->gender) @checked(true) @endif>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female"
                                        value="female" readonly
                                        @if (!$user->gender) @checked(true) @endif>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
<div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" readonly
    value="{{ $user->email }}" 
        placeholder="example@gmail.com">

</div>
<div class="mb-3 row">
    <div class="col-md-6">
        <label for="birth_date" class="form-label">Birth Date</label>
        <input type="date" class="form-control" id="birth_date" name="birth_date" readonly  value="{{ $user->birth_date }}" >
    </div>

    <div class="col-md-6">
        <label for="phone_number" class="form-label">Phone number</label>
        <input type="number" class="form-control" id="phone_number" name="phone_number" readonly  value="{{ $user->default_address->phone_number }}"
            placeholder="0123123123" >
    </div>
</div>
<div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" id="address" name="address"
        placeholder="203 An Dương Vương, phường 01, quận 5, TP.HCM" readonly   value="{{ $user->default_address->address }}">
</div>
<div id="update_customer_response" class="alert m-0 d-none"></div>
</div>
<div class="modal-footer d-none" id='btn-list-edit'>
<button type="reset" class="btn me-auto">Cancel</button>
<button type="submit" class="btn btn-primary">Save changes</button>
</div>
                    </form>
                                            </div>
                                        </div>
                                    </div> <!-- Single Tab Content End -->
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
        @include('pages.account.update_address_modal')
        @include('pages.account.create_address_modal')
    </div>
    
@endsection
