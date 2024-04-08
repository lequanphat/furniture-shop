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
                        Tags Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">

                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#create-tag-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new tag
                        </a>
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
                                        <th>Tag name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tag-table1-body">
                                    @foreach ($tags as $tag)
                                        @if ($loop->index > 7)
                                        @break
                                    @endif
                                    <tr>
                                        <td>{{ $tag->tag_id }}</td>
                                        <td><span class="badge bg-cyan-lt">#{{ $tag->name }}</span>
                                            @if ($tag->created_at->diffInDays() < 7)
                                                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn p-2">
                                                <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;"
                                                    data-bs-toggle="modal" data-bs-target="#update-tag-modal"
                                                    data-id="{{ $tag->tag_id }}" data-name="{{ $tag->name }}" />
                                            </a>
                                            <a href="#" class="js-delete-tag btn p-2"
                                                data-id="{{ $tag->tag_id }}">
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
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tag name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tag-table2-body">
                                @foreach ($tags as $tag)
                                    @if ($loop->index < 8)
                                        @continue
                                    @endif
                                    <tr>
                                        <td>{{ $tag->tag_id }}</td>
                                        <td><span class="badge bg-cyan-lt">#{{ $tag->name }}</span>
                                            @if ($tag->created_at->diffInDays() < 7)
                                                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn p-2">
                                                <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;"
                                                    data-bs-toggle="modal" data-bs-target="#update-tag-modal"
                                                    data-id="{{ $tag->tag_id }}" data-name="{{ $tag->name }}" />
                                            </a>
                                            <a href="#" class="js-delete-tag btn p-2"
                                                data-id="{{ $tag->tag_id }}">
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
            <div class="d-flex justify-content-end my-2">{{ $tags->render('common.pagination') }}
            </div>
        </div>
    </div>
    @include('admin.components.footer')
</div>

{{-- Modal --}}
@include('admin.tags.create_tag_modal')
@include('admin.tags.update_tag_modal')
@include('admin.components.error_delete_modal')
{{-- Script --}}
<script src="{{ asset('js/tag_api.js') }}" defer></script>
@endsection
