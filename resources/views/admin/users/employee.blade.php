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
                        Admin Dashboard
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
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-simple">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new employee
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#modal-report" aria-label="Create new report">
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
                <div class="col-lg-12">
                    <div class="card basic-card">
                        <div class="bootstrap-data-table-panel ">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Avatar</th>
                                            <th>Full name</th>
                                            <th>Gender</th>
                                            <th>Birth date</th>
                                            <th>Email</th>
                                            <th>Phone number</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="employee-table">
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->user_id }}</td>
                                                <td class="d-flex justify-content-center align-items-center">
                                                    <img src="{{ $user->avatar }}" alt="avatar" class="rounded-circle"
                                                        style="width: 40px; height: 40px;">
                                                </td>
                                                <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                                <td>
                                                    @if ($user->gender)
                                                        Male
                                                    @else
                                                        Famale
                                                    @endif
                                                </td>
                                                <td>
                                                    @isset($user->birth_date)
                                                        {{ $user->birth_date }}
                                                    @else
                                                        Unset
                                                    @endisset
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->default_address->phone_number }}</td>

                                                <td>
                                                    @if ($user->is_active)
                                                        <span class="badge badge-success">ACTIVE</span>
                                                    @else
                                                        <span class="badge badge-danger">BANNED</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="/admin/employee/{{ $user->user_id }}/details" type="button"
                                                        class="btn btn-info mr-2 px-2 py-1"><i class="ti-eye"></i></a>
                                                    <button type="button"
                                                        class="js-update-employee-btn btn btn-warning mr-2 px-2 py-1"
                                                        data-user-id="{{ $user->user_id }}"
                                                        data-first-name="{{ $user->first_name }}"
                                                        data-last-name="{{ $user->last_name }}"
                                                        data-gender="{{ $user->gender }}"
                                                        data-birth-date="{{ isset($user->birth_date) ? $user->birth_date : '' }}"
                                                        data-email="{{ $user->email }}"
                                                        data-phone-number="{{ $user->default_address->phone_number }}"
                                                        data-address="{{ $user->default_address->address }}">
                                                        <i class="ti-pencil-alt"></i>
                                                    </button>
                                                    @if ($user->is_active)
                                                        <a href="/admin/employee/{{ $user->user_id }}/ban" type="button"
                                                            class="btn btn-danger mr-2 px-2 py-1">
                                                            <i class="ti-lock"></i>
                                                        </a>
                                                    @else
                                                        <a href="/admin/employee/{{ $user->user_id }}/unban" type="button"
                                                            class="btn btn-success mr-2 px-2 py-1">
                                                            <i class="ti-unlock"></i>
                                                        </a>
                                                    @endif
                                                    <button type="button"
                                                        class="js-delete-employee-btn btn btn-danger px-2 py-1"
                                                        data-user-id="{{ $user->user_id }}"
                                                        data-first-name="{{ $user->first_name }}"
                                                        data-last-name="{{ $user->last_name }}">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /# card -->
                </div>
            </div>
        </div>
        @include('admin.components.footer')
    </div>

    {{-- Modal --}}
    @include('admin.users.create_employee_modal')
    @include('admin.users.update_employee_modal')
    @include('admin.users.delete_employee_confirm')
   
@endsection
