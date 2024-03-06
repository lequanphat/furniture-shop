@extends('layouts.admin')
@section('content')
    <section id="main-content" class="shadow p-3 mb-5 bg-white rounded">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end ">
                    <button type="button" class="btn btn-primary mr-2">
                        <span class=" mr-1">ADD</span>
                        <i class="ti-plus"></i>
                    </button>
                    <button type="button" class="btn btn-primary mr-2">
                        <span class=" mr-1">IMPORT</span>
                        <i class="ti-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="bootstrap-data-table-panel ">
                        <div class="table-responsive">
                            <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Avatar</th>
                                        <th>Full name</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Birth date</th>
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
                                                @isset($user->gender)
                                                    {{ $user->gender }}
                                                @else
                                                    NULL
                                                @endisset
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @isset($user->birth_date)
                                                    {{ $user->birth_date }}
                                                @else
                                                    NULL
                                                @endisset
                                            </td>
                                            <td>
                                                @if ($user->is_active)
                                                    <span class="badge badge-success">ACTIVE</span>
                                                @else
                                                    <span class="badge badge-danger">BANNED</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info mr-2"><i
                                                        class="ti-eye"></i></button>
                                                <button type="button" class="btn btn-warning mr-2"><i
                                                        class="ti-pencil-alt"></i></button>
                                                <button type="button" class="btn btn-danger"><i
                                                        class="ti-trash"></i></button>
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

        @include('admin.components.footer')
    </section>
@endsection
