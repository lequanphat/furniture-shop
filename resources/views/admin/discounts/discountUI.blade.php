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
                                <input id="search" type="text" class="form-control" placeholder="Search…">
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

                            <div class="col-2">
                                <select id="status_type" name="type" class="form-select" title="Choose type">
                                    <option value="all" @if ($type == 'all') selected @endif>All</option>
                                    <option value="active" @if ($type == 'active') selected @endif>Active</option>
                                    <option value="blocked" @if ($type == 'blocked') selected @endif>Blocked</option>
                                </select>

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
                            <select id="status" name="status" class="form-select" title="Choose type">
                                <option value="all" @if ($status == 'all') selected @endif>All</option>
                                <option value="indate" @if ($status == 'indate') selected @endif>In Date</option>
                                <option value="outdate" @if ($status == 'outdate') selected @endif>Out Date</option>
                            </select>



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

                                        <th>start date</th>
                                        <th>end date</th>
                                        <th>is_active</th>
                                        <th>
                                            action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="discounts-table">
                                    @foreach ($discounts as $discount_item)
                                        <tr>
                                            <td>{{ $discount_item->discount_id }}</td>

                                            <td>{{ $discount_item->title }}</td>
                                            <td>
                                                {{ $discount_item->percentage }}%
                                            </td>

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
                                                </button>
{{--                                                <a href="#discount.delete{{ $discount_item->discount_id }}"--}}
{{--                                                   data-bs-toggle="modal" class="btn p-2">--}}

{{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"--}}
{{--                                                         height="24" viewBox="0 0 24 24" fill="none"--}}
{{--                                                         stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
{{--                                                         stroke-linejoin="round"--}}
{{--                                                         class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-trash">--}}
{{--                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />--}}
{{--                                                        <path d="M4 7l16 0" />--}}
{{--                                                        <path d="M10 11l0 6" />--}}
{{--                                                        <path d="M14 11l0 6" />--}}
{{--                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />--}}
{{--                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />--}}
{{--                                                    </svg>--}}
{{--                                                </a>--}}
{{--                                                @include('admin.discounts.deleteDiscount')--}}

                                                <button data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"
                                                        data-discount-id="{{ $discount_item->discount_id }}" class="btn p-2">
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
                                                </button>

                                                <a href="{{ route('discount.detail', $discount_item->discount_id) }}" data-discount-id="{{ $discount_item->discount_id }}" class="btn p-2">
{{--                                                    <a class="btn p-2" data-discount-id="{{ $discount_item->discount_id }}"--}}
{{--                                                     >--}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                         height="24" viewBox="0 0 24 24" fill="none"
                                                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                         stroke-linejoin="round"
                                                         class="action-btn-icon icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>


                                                </a>


                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                {{-- Pagination --}}

                            </div>

                            <div class="js-discount-pagination d-flex justify-content-end my-2">
                                {{ $discounts->render('common.ajax-pagination') }}
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            </td>';
            <script>
                function myFunction() {
                    // Declare variables
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById('myInput');
                    filter = input.value.toUpperCase();
                    table = document.getElementById('myTable');
                    tr = table.getElementsByTagName('tr');

                    // Loop through all table rows, and hide those who don't match the search query
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName('td')[1];
                        // fast find follow title [1];
                        // Tip: Change tr[i].getElementsByTagName('td')[0] to [1] if you want to search for "Country" (index 1) instead of "Name" (index 0).
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = '';
                            } else {
                                tr[i].style.display = 'none';
                            }
                        }
                    }
                }
            </script>

            @include('admin.discounts.CreateDiscount')
            @include('admin.discounts.UpdateDiscount')
            @include('admin.discounts.deleteDiscount')
            @include('admin.components.footer')
            @include('admin.components.delete_confirm_modal')
            @include('admin.discounts.deleteDiscount')
            <script src="{{ asset('js/discount_api.js') }}" defer></script>

        </div>
    </section>
    {{-- Script --}}
    <!-- <script src="{{ asset('js/discount_api.js') }}" defer></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <!-- Render to table Data -->
    <!-- <script>
    $(document).ready(function() {
var is_empty = true;
        fetch_customer_data();

        function fetch_customer_data(query = '') {
            if (!is_empty){




            $.ajax({
                url: "{{ route('discount.liveSearch') }}",
                method: 'GET',
                data: {
                    query: query
                },

                dataType: 'json',

                success: function(data) {
                    $('#discounts-table').html(data.table_data);



                    $('#total_records').text(data.total_data);
                }

            })

            console.log("Test Take Input Data From Fetch CusTomer Data");
        }
        }

        // $(document).on('keyup', '#search', function() {
        //     var query = $(this).val();
        //     fetch_customer_data(query);
        // });
        $(document).on('keyup', '#search', function() {
            var query = $(this).val();
            if (query.trim().length > 0) {
                is_empty = false;
                fetch_customer_data(query);
            }
            else{
                is_empty = true;
                location.reload();
            }
        });
    });
</script> -->

@endsection
