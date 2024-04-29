@extends('layouts.app')
@section('content')
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
                                    <a href="#dashboard" class="active" data-bs-toggle="tab">Dashboard</a>
                                    <a href="#address-edit" data-bs-toggle="tab">Address</a>
                                    <a href="/change-password">Change password</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">

                                    <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Account Details</h3>
                                            <div class="account-details-form">
                                                <form id="update-profile-customer-form" action="#">
                                                    @csrf
                                                    <div class="col-12">
                                                        <div class="mb-3 row">
                                                            <div class="col-md-6">
                                                                <label for="first_name" class="form-label">First
                                                                    Name</label>
                                                                <input type="text" class="form-control" id="first_name"
                                                                    name="first_name" placeholder="Cristiano"
                                                                    value="{{ $user->first_name }}" readonly>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="last_name" class="form-label">Last Name</label>
                                                                <input type="text" class="form-control" id="last_name"
                                                                    name="last_name" placeholder="Ronaldo"
                                                                    value="{{ $user->last_name }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="gender" id="male" value="male" readonly
                                                                    @if ($user->gender) @checked(true) @endif>
                                                                <label class="form-check-label" for="male">Male</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="gender" id="female" value="female" readonly
                                                                    @if (!$user->gender) @checked(true) @endif>
                                                                <label class="form-check-label"
                                                                    for="female">Female</label>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email address</label>
                                                            <input type="email" class="form-control" id="email"
                                                                name="email" readonly value="{{ $user->email }}"
                                                                placeholder="example@gmail.com">

                                                        </div>
                                                        <div class="mb-3 row">
                                                            <div class="col-md-6">
                                                                <label for="birth_date" class="form-label">Birth
                                                                    Date</label>
                                                                <input type="date" class="form-control" id="birth_date"
                                                                    name="birth_date" readonly
                                                                    value="{{ $user->birth_date }}">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="phone_number" class="form-label">Phone
                                                                    number</label>
                                                                <input type="phone" class="form-control" id="phone_number"
                                                                    name="phone_number" readonly placeholder="0123123123"
                                                                    value="@if (isset($user->default_address->phone_number)) {{ $user->default_address->phone_number }} @endif">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Address</label>
                                                            <input type="text" class="form-control" id="address"
                                                                name="address"
                                                                placeholder="203 An Dương Vương, phường 01, quận 5, TP.HCM"
                                                                readonly
                                                                value="@if (isset($user->default_address->address)) {{ $user->default_address->address }} @endif">
                                                        </div>
                                                        <div id="update_customer_response" class="alert m-0 d-none"></div>
                                                    </div>
                                                    <div class="modal-footer d-none" id='btn-list-edit'>
                                                        <button id="cancel-edit-profile-customer" type="button"
                                                            class="btn btn-secondary">Cancel</button>
                                                        <button type="submit"
                                                            class="btn btn-primary update-profile-btn">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                                <div class="col-auto ms-auto d-print-none">
                                                    <div class="btn-list btn-edit-profile">
                                                        <button class="btn btn-primary edit-profile-btn"
                                                            id="enable-edit-profile-customer">
                                                            Edit profile
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade " id="address-edit" role="tabpanel">
                                        <div class="myaccount-content">
                                            <div class="address-header">
                                                <h3>Billing Address</h3>
                                                <button class="check-btn sqr-btn create-address-btn"
                                                    data-bs-toggle="modal" data-bs-target="#CreateAddressModal"
                                                    data-user-id="{{ $user->user_id }}">
                                                    <i class="fa fa-plus"></i> Create
                                                    Address</button>
                                            </div>


                                            <div id="address_table">

                                                @foreach ($address_cards as $address)
                                                    <div class="address-item {{ $address->address_id }}">
                                                        <div class="address-info">
                                                            <div class="header">
                                                                <p class="receiver-name">{{ $address->receiver_name }}</p>
                                                                <p>{{ $address->phone_number }}</p>
                                                            </div>
                                                            <p>{{ $address->address }}</p>
                                                            @if ($address->is_default)
                                                                <div class="default-tag">Default</div>
                                                            @endif
                                                        </div>
                                                        <div class="address-action">
                                                            <button class="update-btn" data-bs-toggle="modal"
                                                                data-bs-target="#UpdateAddressModal"
                                                                data-address-id="{{ $address->address_id }}"
                                                                data-receiver-name="{{ $address->receiver_name }}"
                                                                data-address="{{ $address->address }}"
                                                                data-phone-number="{{ $address->phone_number }}"
                                                                data-is-default="{{ $address->is_default ? 'true' : 'false' }}"><i
                                                                    class="fa fa-edit"></i> Update</button>
                                                            <button class="remove-btn" data-bs-toggle="modal"
                                                                data-bs-target="#RemoveAddressModal"
                                                                data-address-id="{{ $address->address_id }}"><i
                                                                    class="fa fa-remove"></i>
                                                                Remove</button>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>

                                    </div>
                                    <!-- Single Tab Content End -->
                                    <!-- Single Tab Content Start -->

                                    <!-- Single Tab Content End -->
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
        @include('pages.account.update_address_modal')
        @include('pages.account.create_address_modal')
        @include('pages.account.remove_address_modal')
    </div>
@endsection
