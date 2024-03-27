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
                        <span class="d-none d-sm-inline">
                            <a href="#" class="btn">
                                New view
                            </a>
                        </span>
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
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Color</th>
                                    </tr>
                                </thead>
                                <tbody id="color-table-body">
                                    @foreach ($colors as $color)
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
                                                    style="background: {{ $color->code }}; width: 20px; height: 20px;">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end my-2">{{ $colors->render('common.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.components.footer')
    </div>

    {{-- Modal --}}
    @include('admin.colors.create_color_modal')
@endsection
