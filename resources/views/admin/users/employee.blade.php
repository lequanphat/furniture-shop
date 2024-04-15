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
                        Employee Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="row justify-content-end">
                        <div class="@can('create user') col-4 @else col-7 @endcan">
                            <div class="input-icon ">
                                <input id="search-employee-input" type="text" value="{{ $search }}"
                                    class="form-control" placeholder="Search…">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="@can('create user') col-3 @else col-5   @endcan"><select id="select-employee-type"
                                name="type" class="form-select">
                                <option value="all" @if ($type == 'all') selected @endif>All</option>
                                <option value="active" @if ($type == 'active') selected @endif>Active</option>
                                <option value="blocked" @if ($type == 'blocked') selected @endif>Blocked</option>
                            </select>
                        </div>
                        @can('create user')
                            <div class="col-auto">
                                <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                    data-bs-target="#create-employee-modal">
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
                            </div>
                        @endcan

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
                            <table class="js-user-table table table-vcenter table-mobile-md card-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Gender</th>
                                        <th>Birth date</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="employee-table-body">
                                    @if ($users->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->user_id }}</td>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url({{ $user->avatar }})"></span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">
                                                                {{ $user->first_name . ' ' . $user->last_name }}
                                                                @if ($user->created_at->diffInDays() < 7)
                                                                    <span
                                                                        class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-muted"><a href="#"
                                                                    class="text-reset">{{ $user->email }}</a></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        @if ($user->gender)
                                                            Male
                                                        @else
                                                            Famale
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @isset($user->birth_date)
                                                        {{ $user->birth_date }}
                                                    @else
                                                        Unset
                                                    @endisset
                                                </td>
                                                <td class="text-muted">
                                                    <div>
                                                        @if (isset($user->default_address->phone_number))
                                                            {{ $user->default_address->phone_number }}
                                                        @else
                                                            Unset
                                                        @endif
                                                    </div>
                                                    <div>
                                                        @if (isset($user->default_address->address))
                                                            {{ $user->default_address->address }}
                                                        @else
                                                            Unset
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($user->is_active)
                                                        <span class="badge bg-success me-1"></span> Active
                                                    @else
                                                        <span class="badge bg-danger me-1"></span> Blocked
                                                    @endif

                                                </td>
                                                <td>
                                                    <a href="employee/{{ $user->user_id }}/details" class="btn p-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path
                                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                        </svg>
                                                    </a>
                                                    @can('update user')
                                                        <a href="#" class="btn p-2" data-bs-toggle="modal"
                                                            data-bs-target="#update-employee-modal"
                                                            data-user-id="{{ $user->user_id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                                <path d="M13.5 6.5l4 4" />
                                                            </svg>
                                                        </a>
                                                    @endcan
                                                    @can('delete user')
                                                        @if ($user->is_active)
                                                            <a href="#" class="btn p-2" data-bs-toggle="modal"
                                                                data-bs-target="#delete-user-modal"
                                                                data-user-id="{{ $user->user_id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </a>
                                                        @else
                                                            <a href="#" class="btn p-2" data-bs-toggle="modal"
                                                                data-bs-target="#restore-user-modal"
                                                                data-user-id="{{ $user->user_id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-key">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                                                                    <path d="M15 9h.01" />
                                                                </svg>
                                                            </a>
                                                        @endif
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end my-2  js-employee-pagination">
                                {{ $users->render('common.ajax-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.components.footer')
    </div>




    {{-- Modal --}}
    @include('admin.users.create_employee_modal')
    @include('admin.users.update_employee_modal')
    @include('admin.users.delete_confirm_modal')
    @include('admin.users.restore_confirm_modal')
    @include('admin.users.success_notify_modal')
    {{-- Script --}}
    <script src="{{ asset('js/users_api.js') }}" defer></script>
@endsection
