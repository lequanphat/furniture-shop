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
                    <h2 class="page-title" id="page-title">
                        Your Profile
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" id="enable-edit-profile-employee">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            Edit profile
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
                        <form id="update-profile-employee-form" action="#">
                            @csrf
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center justify-content-center"
                                        style="width: 80px; height: 80px;">
                                        <label for="avatar"
                                            class="d-flex align-items-center justify-content-center rounded-circle border"
                                            style="width: 100%; height: 100%; background-color: #f8f9fa; cursor: pointer; border-style: dashed;">
                                            <image id="imagePreview" class="icon" style="width: 80px; height: 80px;"
                                                src="{{ $user->avatar }}">
                                        </label>
                                        <input class="d-none" type="file" name="avatar" id="avatar" accept="image/*"
                                            disabled>
                                    </div>
                                </div>
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
                                        value="{{ $user->email }}" placeholder="example@gmail.com">

                                </div>
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="birth_date" class="form-label">Birth Date</label>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date"
                                            readonly value="{{ $user->birth_date }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone_number" class="form-label">Phone number</label>
                                        <input type="phone" class="form-control" id="phone_number" name="phone_number"
                                            readonly
                                            value="@if (isset($user->default_address->phone_number)) {{ $user->default_address->phone_number }} @endif"
                                            placeholder="0123123123">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="203 An Dương Vương, phường 01, quận 5, TP.HCM" readonly
                                        value="@if (isset($user->default_address->address)) {{ $user->default_address->address }} @endif">
                                </div>
                                <div id="update_employee_response" class="alert m-0 d-none"></div>
                            </div>
                            <div class="modal-footer d-none" id='btn-list-edit'>
                                <button type="reset" class="btn me-auto">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('admin.components.footer')
        </div>

        {{-- Script --}}
        <script src="{{ asset('js/profile_admin.js') }}" defer></script>
    @endsection
