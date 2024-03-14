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
                        Customers Management
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
                            Create new customer
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
    {{-- Page body --}}
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Gender</th>
                                        <th>Birth date</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>

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
                                                @if (isset($user->is_active))
                                                    <span class="badge bg-success me-1"></span> Active
                                                @else
                                                    <span class="badge bg-danger me-1"></span> Blocked
                                                @endif

                                            </td>
                                            <td>
                                                <a href="#" class="btn p-2">
                                                    <img src="{{ asset('svg/view.svg') }}" style="width: 18px;" />
                                                </a>
                                                <a href="#" class="btn p-2">
                                                    <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                </a>
                                                <a href="#" class="btn p-2">
                                                    <img src="{{ asset('svg/trash.svg') }}" style="width: 18px;" />
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.components.footer')
        </section>
    @endsection
