@extends('layouts.admin')
@section('content')
    <section id="main-content" class="shadow p-3 bg-white rounded">
        <div class="row">
            <div class="col-lg-6 ">
                <h5>The list of Customer</h5>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-end ">
                    <button type="button" class="btn btn-primary mr-2">
                        <span class=" mr-1">CREATE</span>
                        <i class="ti-plus"></i>
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="ti-reload"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card basic-card">
                    <div class="bootstrap-data-table-panel">
                        <div class="table-responsive">
                            <table id="row-select" class="display table table-borderd table-hover">
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
                                <tbody>
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
                                            <td>
                                                @if (isset($user->default_address->phone_number))
                                                    {{ $user->default_address->phone_number }}
                                                @else
                                                    Unset
                                                @endif
                                            </td>

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
            <!-- /# column -->
        </div>
        <!-- /# row -->

        {{-- Modal --}}
        @include('admin.users.create_employee_modal')

        @include('admin.components.footer')
    </section>
@endsection
