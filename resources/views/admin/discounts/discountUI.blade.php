@extends('layouts.admin')
@section('content')
    <section id="main-content">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <!-- Page pre-title -->

                        <div class="page-pretitle">
                            Overview
                        </div>
                        <h2 class="page-title">
                            Discount Management
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
                               data-bs-target="#modal-discount-create">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Create new Discount
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

            <div class="input-group mb-3 container-xl">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button"><img src="{{ asset('svg/find.svg') }}"
                                                                                 style="width: 18px;" /></button>

                </div>

                <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
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
                                        <th>Discount_id</th>
                                        <th>Title</th>
                                        <th>description</th>
                                        <th>percentage</th>
                                        <th>amount</th>
                                        <th>start_date</th>
                                        <th>end_date</th>
                                        <th>is_active</th>
                                        <th>
                                            action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="employee-table">
                                    @foreach ($discounts as $discount_item)
                                        <tr>
                                            <td>{{ $discount_item->discount_id }}</td>

                                            <td>{{ $discount_item->title }}</td>
                                            <td>{{ $discount_item->discription }}</td>
                                            <td>
                                                {{ $discount_item->percentage }}
                                            </td>
                                            <td> {{ $discount_item->amount }}</td>
                                            <td>{{ $discount_item->start_date }}</td>
                                            <td>{{ $discount_item->end_date }}</td>
                                            <td>{{ $discount_item->is_active }}</td>

                                            {{-- temporary value --}}
                                            <td>
                                                <button
                                                    class="btn btn-primary d-none d-sm-inline-block  js-update-discount-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-discount-update"

                                                    data-discount-id="{{ $discount_item->discount_id }}"
                                                    data-title="{{ $discount_item->title }}"
                                                    data-description="{{ $discount_item->description }}"
                                                    data-amount="{{ $discount_item->amount }}"
                                                    data-start-date="{{ $discount_item->start_date }}"
                                                    data-end-date="{{$discount_item->end_date}}"
                                                    data-is-active="{{$discount_item->is_active}}"
                                                    data-percentage="{{$discount_item->percentage}}"
                                                >

                                                    <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                </button>
                                                <button
                                                    class="btn btn-primary d-none d-sm-inline-block  js-delete-discount-btn"

                                                >
                                                    <img src="{{ asset('svg/trash.svg') }}" style="width: 18px;" />


                                                </button>
                                            </td>

                                    @endforeach

                                    </tbody>
                                </table>
                                {{-- Pagination --}}
                                <ul class="pagination my-2 ms-auto">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M15 6l-6 6l6 6" />
                                            </svg>
                                            prev
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            next
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                 height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M9 6l6 6l-6 6" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.discounts.CreateDiscount')
            @include('admin.discounts.UpdateDiscount')

            @include('admin.components.footer')
        </div>


    </section>
@endsection
