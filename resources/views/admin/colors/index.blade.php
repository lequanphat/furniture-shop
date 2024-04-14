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
                        Colors Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">

                        @can('create color')
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#create-color-modal">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Create new color
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Color Name</th>
                                        <th>Color</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="color-table1-body">
                                    @foreach ($colors as $color)
                                        @if ($loop->index > 7)
                                        @break
                                    @endif
                                    <tr>
                                        <td>{{ $color->color_id }}</td>
                                        <td>{{ $color->name }}
                                            @if ($color->created_at->diffInDays() < 7)
                                                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="col-auto rounded"
                                                style="background: {{ $color->code }}; width: 20px; height: 20px; border: 1px solid #ccc">
                                            </div>
                                        </td>
                                        <td>
                                            @can('update color')
                                                <a class="btn p-2" data-bs-toggle="modal"
                                                    data-bs-target="#update-color-modal" data-id="{{ $color->color_id }}"
                                                    data-name="{{ $color->name }}" data-code="{{ $color->code }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                        <path d="M13.5 6.5l4 4" />
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('delete color')
                                                <a href="#" class="js-delete-color btn p-2"
                                                    data-id="{{ $color->color_id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                            </tbody>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Color Name</th>
                                    <th>Color</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="color-table2-body">
                                @foreach ($colors as $color)
                                    @if ($loop->index < 8)
                                        @continue
                                    @endif
                                    <tr>
                                        <td>{{ $color->color_id }}</td>
                                        <td>{{ $color->name }}
                                            @if ($color->created_at->diffInDays() < 7)
                                                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="col-auto rounded"
                                                style="background: {{ $color->code }}; width: 20px; height: 20px; border: 1px solid #ccc;">
                                            </div>
                                        </td>
                                        <td>

                                            @can('update color')
                                                <a class="btn p-2" data-bs-toggle="modal"
                                                    data-bs-target="#update-color-modal" data-id="{{ $color->color_id }}"
                                                    data-name="{{ $color->name }}" data-code="{{ $color->code }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                        <path d="M13.5 6.5l4 4" />
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('delete color')
                                                <a href="#" class="js-delete-color btn p-2"
                                                    data-id="{{ $color->color_id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                            </tbody>
                        </table>
                        <div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="d-flex justify-content-end my-2">{{ $colors->render('common.pagination') }}
            </div>
        </div>
    </div>
    @include('admin.components.footer')
</div>

{{-- Modal --}}
@include('admin.colors.create_color_modal')
@include('admin.colors.update_color_modal')
@include('admin.components.error_delete_modal')


{{-- Script --}}
<script src="{{ asset('js/color_api.js') }}" defer></script>
@endsection
