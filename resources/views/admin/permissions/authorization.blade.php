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
                        Authorization Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="row">
                        <div class="col-7 input-icon">
                            <input id="search-authorization-input" type="text" class="form-control" placeholder="Search…"
                                value="{{ $search }}">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </span>
                        </div>
                        <div class="col-5"><select id="select-authorization-type" name="type" class="form-select">
                                <option value="all" @if ($type == 'all') selected @endif>All</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @if ($role->name == $type) selected @endif>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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

                            <table class="table table-vcenter table-mobile-md card-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody id="authorization-table-body">
                                    @if ($employees->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($employees as $employee)
                                            <tr>
                                                <td>{{ $employee->user_id }}</td>
                                                <td data-label="Name">
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url({{ $employee->avatar }})"></span>
                                                        <div class="flex-fill">
                                                            <div class="js-fullname font-weight-medium">
                                                                {{ $employee->full_name() }}</div>
                                                            <div class="text-muted"><a href="#"
                                                                    class="text-reset">{{ $employee->email }}</a></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-muted">
                                                    <div>
                                                        @if (isset($employee->default_address->phone_number))
                                                            {{ $employee->default_address->phone_number }}
                                                        @else
                                                            Unset
                                                        @endif
                                                    </div>
                                                    <div>
                                                        @if (isset($employee->default_address->address))
                                                            {{ $employee->default_address->address }}
                                                        @else
                                                            Unset
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($employee->is_active)
                                                        <span class="badge bg-success me-1"></span> Active
                                                    @else
                                                        <span class="badge bg-danger me-1"></span> Blocked
                                                    @endif

                                                </td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <div class="dropdown js-dropdown-role ">
                                                            <button class="btn dropdown-toggle align-text-top"
                                                                @can(['create role', 'update role', 'delete role'])
                                                                @else
                                                                disabled
                                                            @endcan
                                                                data-bs-toggle="dropdown">
                                                                @if (!$employee->getRoleNames()->isEmpty())
                                                                    {{ $employee->getRoleNames()->first() }}
                                                                @else
                                                                    Unset
                                                                @endif
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                @foreach ($roles as $role)
                                                                    @if ($employee->hasRole($role->name))
                                                                        @continue
                                                                    @endif
                                                                    <a class="js-change-role dropdown-item"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#assign-role-confirm-modal">{{ $role->name }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="js-authorization-pagination d-flex justify-content-end my-2">
                            {{ $employees->render('common.ajax-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.components.footer')
    </div>


    {{-- Modal --}}
    @include('admin.permissions.assign_role_confirm_modal')

    {{-- Script --}}
    <script src="{{ asset('js/permission.js') }}" defer></script>
@endsection
