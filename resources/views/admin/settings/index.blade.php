@extends('layouts.admin')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Account Settings
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col-3 d-none d-md-block border-end ">
                        <div class="card-body">
                            <h4 class="subheader">Business settings</h4>
                            <div class="list-group list-group-transparent">
                                <a href="{{ route('settings.index') }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center active">My
                                    Account</a>
                                <a href="{{ route('settings.change_password') }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center">Change
                                    password</a>
                            </div>

                            <div class="list-group list-group-transparent">
                                <a href="/logout" class="list-group-item list-group-item-action text-danger">Logout</a>
                            </div>
                        </div>
                    </div>
                    <form id="update-profile-form" action="#" method="POST" class="col d-flex flex-column">
                        @csrf
                        <div class="card-body">

                            <h2 class="mb-4">My Account</h2>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto"><span id="avatar-image" class="avatar avatar-xl"
                                        style="background-image: url({{ Auth::user()->avatar }})"></span>
                                </div>
                                <div class="col-auto">
                                    <label for="avatar-input" class="btn">Change avatar</label>
                                    <input type="file" class="d-none" name="avatar" id="avatar-input">
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md">
                                    <div class="form-label">First name</div>
                                    <input name="first_name" type="text" class="form-control"
                                        value="{{ Auth::user()->first_name }}">
                                </div>
                                <div class="col-md">
                                    <div class="form-label">Last name</div>
                                    <input name="last_name" type="text" class="form-control"
                                        value="{{ Auth::user()->last_name }}">
                                </div>


                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md">
                                    <div class="form-label">Birth date</div>
                                    <label class="form-check form-switch form-switch-lg">
                                        <input name="gender" class="form-check-input" type="checkbox"
                                            @if (!Auth::user()->gender) @checked(true) @endif>
                                        <span class="form-check-label form-check-label-on">Female</span>
                                        <span class="form-check-label form-check-label-off">Male</span>
                                    </label>
                                </div>

                                <div class="col-md">
                                    <div class="form-label">Birth date</div>
                                    <input name="birth_date" type="date" class="form-control"
                                        value="{{ Auth::user()->birth_date }}">
                                </div>

                            </div>
                            <div class="row g-3">
                                <div class="col-md">
                                    <div class="form-label">Email</div>
                                    <input name="email" type="text" class="form-control"
                                        value="{{ Auth::user()->email }}" readonly>
                                </div>
                                <div class="col-md">
                                    <div class="form-label">Phone number</div>
                                    <input name="phone_number" type="text" class="form-control"
                                        value="@if (isset(Auth::user()->default_address->phone_number)) {{ Auth::user()->default_address->phone_number }} @endif">
                                </div>
                                <div class="col-12">
                                    <div class="form-label">Address</div>
                                    <input name="address" type="text" class="form-control"
                                        value="@if (isset(Auth::user()->default_address->address)) {{ Auth::user()->default_address->address }} @endif">
                                </div>

                            </div>
                            <div id="update_response" class="alert m-0 mt-3 d-none"></div>
                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-end">
                                <a href="{{ route('settings.index') }}" class="btn">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.components.footer')
    </div>
    {{-- Script --}}
    <script src="{{ asset('js/settings.js') }}" defer></script>
@endsection
