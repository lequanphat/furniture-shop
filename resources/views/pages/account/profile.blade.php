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
                                            <a href="#" class="check-btn sqr-btn " 
                                            data-bs-toggle="modal" data-bs-target="#UpdateAddressModal" 
                                                    data-address-id="{{$address->address_id}}"
                                                    data-receiver-name="{{ $address->receiver_name }}"
                                                    data-address="{{ $address->address }}"
                                                    data-phone-number="{{ $address->phone_number }}"
                                                    data-is-default="{{ $address->is_default}}">
                                            <i class="fa fa-edit"></i> Edit
                                                Address</a>
                                                <h3></h3>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Account Details</h3>
                                            <div class="account-details-form">
                                                <form action="#" id="update-profile-customer-form">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                            <label class="form-label required">First name</label>
                                    <input type="text" class="form-control" autocomplete="off"
                                        value="{{ $user->first_name }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                            <label class="form-label required">Last name</label>
                                    <input type="text" class="form-control" autocomplete="off"
                                        value="{{ $user->last_name }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-input-item">
                                                    <div class="form-check form-check-inline">
                                    <input class="" type="radio" name="gender" id="male"
                                        value="male" required
                                        @if ($user->gender) @checked(true) @endif>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="" type="radio" name="gender" id="female"
                                        value="female" required
                                        @if (!$user->gender) @checked(true) @endif>
                                    <label class="form-check-label" for="female">Female</label>
                                </div> 
                                                    </div>
                                                    <div class="single-input-item">
                                                    <label class="form-label required">Email address</label>
                                <input type="text" class="form-control" autocomplete="off" readonly
                                    value="{{ $user->email }}" />
                                                    </div>
                                                    <div class="single-input-item">
                                                    <div class="col-6">
                                    <label class="form-label required">Birth date</label>
                                    <input type="text" class="form-control" autocomplete="off"
                                        value="{{ $user->birth_date }}" />
                                </div>
                                <div class="col-6">
                                    <label class="form-label required">Phone number</label>
                                    <input type="text" class="form-control" autocomplete="off"
                                        value="{{ isset($user->default_address->phone_number) ? $user->default_address->phone_number : '' }}" />
                                </div>
</div>
<div class="single-input-item">
<label class="form-label required">Address</label>
                                <input type="text" class="form-control" autocomplete="off"
                                    value="{{ isset($user->default_address->address) ? $user->default_address->address : '' }}" />
</div>
                                                    <div class="single-input-item btn-hover">
                                                        <button class="check-btn sqr-btn">Save Changes</button>
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
    </div>
@endsection
