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
                                    class="list-group-item list-group-item-action d-flex align-items-center ">My
                                    Account</a>
                                <a href="{{ route('settings.change_password') }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center active">Change
                                    password</a>
                            </div>

                            <div class="list-group list-group-transparent">
                                <a href="/logout" class="list-group-item list-group-item-action text-danger">Logout</a>
                            </div>
                        </div>
                    </div>
                    <form id="change-password-form" action="#" method="POST" class="col d-flex flex-column">
                        @csrf
                        <div class="card-body">

                            <h2 class="mb-4">Change password</h2>

                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-12 col-lg-5">
                                    <div class="form-label">Old password</div>
                                    <input name="password" type="password" class="form-control"
                                        placeholder="Enter your old password">
                                </div>

                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-12 col-lg-5">
                                    <div class="form-label">New password</div>
                                    <input name="new_password" type="password" class="form-control"
                                        placeholder="Enter your new password">
                                </div>
                            </div>
                            <div id="update_response" class="alert m-0 mt-3 d-none"></div>
                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-end">
                                <a href="{{ route('settings.change_password') }}" class="btn">
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
