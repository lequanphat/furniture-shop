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
                            <div class="input-icon ">
                                <input id="myInput" onkeyup="myFunction()" type="text" class="form-control"
                                    placeholder="Search..." aria-label="" aria-describedby="basic-addon1">
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
                                <table id="myTable" class="table table-vcenter card-table">
                                    <thead>

                                        <tr>
                                            <th>Discount_id</th>
                                            <th>Title</th>
                                            <th>percentage</th>
                                            <th>amount</th>
                                            <th>start date</th>
                                            <th>end date</th>
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
                                                <td>
                                                    {{ $discount_item->percentage }}%
                                                </td>
                                                <td>{{ number_format($discount_item->amount, 0, '.', ',') }}đ </td>
                                                <td>{{ $discount_item->start_date }}</td>
                                                <td>{{ $discount_item->end_date }}</td>
                                                <td>
                                                    @if ($discount_item->is_active)
                                                        <span class="badge bg-success me-1"></span> Active
                                                    @else
                                                        <span class="badge bg-danger me-1"></span> Blocked
                                                    @endif
                                                </td>

                                                {{-- temporary value --}}
                                                <td>
                                                    <button class="btn p-2 d-none d-sm-inline-block  js-update-discount-btn"
                                                        data-bs-toggle="modal" data-bs-target="#modal-discount-update"
                                                        data-discount-id="{{ $discount_item->discount_id }}"
                                                        data-title="{{ $discount_item->title }}"
                                                        data-description="{{ $discount_item->description }}"
                                                        data-amount="{{ $discount_item->amount }}"
                                                        data-start-date="{{ $discount_item->start_date }}"
                                                        data-end-date="{{ $discount_item->end_date }}"
                                                        data-is-active="{{ $discount_item->is_active }}"
                                                        data-percentage="{{ $discount_item->percentage }}">
                                                        <img src="{{ asset('svg/edit.svg') }}" style="width: 18px;" />
                                                    </button>
                                                    <a href="#discount.delete{{ $discount_item->discount_id }}"
                                                        data-bs-toggle="modal" class="btn p-2"><img
                                                            src="{{ asset('svg/trash.svg') }}" style="width: 18px;" /></a>
                                                    @include('admin.discounts.deleteDiscount')

                                                </td>
                                        @endforeach

                                    </tbody>
                                </table>
                                {{-- Pagination --}}
                                <div class="d-flex justify-content-end my-2">{{ $discounts->render('common.pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function myFunction() {
                    // Declare variables
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable");
                    tr = table.getElementsByTagName("tr");

                    // Loop through all table rows, and hide those who don't match the search query
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[1];
                        // fast find follow title [1];
                        // Tip: Change tr[i].getElementsByTagName('td')[0] to [1] if you want to search for "Country" (index 1) instead of "Name" (index 0).
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>
            @include('admin.discounts.CreateDiscount')
            @include('admin.discounts.UpdateDiscount')
            @include('admin.components.footer')
        </div>
    </section>
    {{-- Script --}}
    <script src="{{ asset('js/discount_api.js') }}" defer></script>
@endsection
