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
                        Roles Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="row justify-content-end">
                        <div class="@can('create role') col-5 @else col-7 @endcan">
                            <div class="input-icon ">
                                <input id="search-roles-input" type="text" value="{{ $search }}"
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
                        <div class="@can('create role') col-3 @else col-5   @endcan"><select id="select-roles-sort"
                                name="type" class="form-select">
                                <option value="default" @if ($sort == 'default') selected @endif>Default</option>
                                <option value="asc" @if ($sort == 'asc') selected @endif>Permissions
                                    Ascending</option>
                                <option value="desc" @if ($sort == 'desc') selected @endif>
                                    Permissions Descending</option>
                            </select>
                        </div>
                        @can('create role')
                            <div class="col-auto">
                                <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                    data-bs-target="#create-role-modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Create new role
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#create-role-modal"
                                    class="btn btn-primary d-sm-none btn-icon" aria-label="Create new report">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
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
                            <table class="js-user-table table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role name</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="roles-table-body">
                                    @if ($roles->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }} @if ($role->created_at->diffInDays() < 7)
                                                        <span class="badge bg-green-lt">New</span>
                                                    @endif
                                                </td>
                                                <td>{{ $role->permissions->count() }} permissions</td>
                                                <td>
                                                    @can('update role')
                                                        <a class="btn p-2" data-role-id="{{ $role->id }}"
                                                            data-bs-toggle="modal" data-bs-target="#update-role-modal">
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
                                                    @can('delete role')
                                                        <a href="#" class="btn p-2" data-role-id="{{ $role->id }}"
                                                            data-role-name="{{ $role->name }}" data-bs-toggle="modal"
                                                            data-bs-target="#delete-confirm-modal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="js-roles-pagination d-flex justify-content-end my-2">
                            {{ $roles->render('common.ajax-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.components.footer')
    </div>

    {{-- Modal --}}
    @include('admin.permissions.create_role_modal')
    @include('admin.permissions.update_role_modal')
    @include('admin.components.delete_confirm_modal')
    @include('admin.components.error_delete_modal')

    {{-- Script --}}
    <script src="{{ asset('js/permission.js') }}" defer></script>
@endsection
