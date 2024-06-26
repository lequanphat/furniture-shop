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
                        Customer Details
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-4">
                    <div class="card">
                        <fieldset class="form-fieldset m-0">
                            <div class="mb-3 row">
                                <div class="col-6">
                                    <label class="form-label required">First name</label>
                                    <input type="text" class="form-control" autocomplete="off"
                                        value="{{ $user->first_name }}" readonly />
                                </div>
                                <div class="col-6">
                                    <label class="form-label required">Last name</label>
                                    <input type="text" class="form-control" autocomplete="off"
                                        value="{{ $user->last_name }}" readonly />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male"
                                        value="male" required readonly
                                        @if ($user->gender) @checked(true) @endif>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female"
                                        value="female" required readonly
                                        @if (!$user->gender) @checked(true) @endif>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Email address</label>
                                <input type="text" class="form-control" autocomplete="off" readonly
                                    value="{{ $user->email }}" />
                            </div>

                            <div class="mb-3 row">
                                <div class="col-6">
                                    <label class="form-label required">Birth date</label>
                                    <input type="text" class="form-control" autocomplete="off"
                                        value="{{ $user->birth_date }}" readonly />
                                </div>
                                <div class="col-6">
                                    <label class="form-label required">Phone number</label>
                                    <input type="text" class="form-control" autocomplete="off"
                                        value="{{ isset($user->default_address->phone_number) ? $user->default_address->phone_number : '' }}" readonly />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Address</label>
                                <input type="text" class="form-control" autocomplete="off"
                                    value="{{ isset($user->default_address->address) ? $user->default_address->address : '' }}" readonly />
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Temp</th>
                                        <th>Temp</th>
                                        <th>Temp</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.components.footer')
    </div>
@endsection
