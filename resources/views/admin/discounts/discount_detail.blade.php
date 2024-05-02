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
                        Discount Details
                    </h2>
                </div>
                <!-- Page title actions -->


                <div class="input-icon col-2">
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
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-back">
                    <span class="d-none d-sm-inline">
                        <a href="/admin/discounts" class="btn">
                            Back
                        </a>

                    </span>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body mb-2">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <form id="create-product-form" action="#" method="POST" class="card">
                        <div class="card-body">

                            <div class="row row-cards">
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="title" class="form-label"> Title</label>
                                        <input id="title" name="title" type="text" class="form-control"
                                               placeholder="High quality plastic tables and chairs"
                                               value="{{$discount->title}}" readonly>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">amount</label>
                                    <input id="amount" name="amount" class="form-control" type="text" value="{{$discount->amount}}" readonly>


                                </div>
                            </div> -->
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="active" class="form-label">is active</label>


                                        <input id="active" name="active" class="form-control" type="text"
                                               value="{{ $discount->is_active === 0 ? 'Off' : 'On' }}" readonly>


                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">start Date</label>

                                        <input class="form-control" type="date" id="startdate" name="startdate"
                                               value="{{$discount->start_date}}">

                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">end Date</label>

                                        <input class="form-control" type="date" id="enddate" name="enddate"
                                               value="{{$discount->end_date }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Percentage</label>
                                        <input class="form-control" type="number" id="percentage" name="percentage"
                                               min="0" max="100 " value="{{$discount->percentage}}">
                                    </div>
                                </div>


                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="page-body mt-2">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            {{--                        <div  class="scrollable-table" style="max-height: 400px; overflow-y: auto;">--}}
                            <div class="table-responsive " style="max-height: 400px; overflow-y: auto;">
                                <form id="update-discount-product-form" action="#" method="POST">
                                    @csrf
                                    <table class="js-user-table table table-vcenter card-table ">
                                        <thead style="position: sticky; top: 0; z-index: 1; background-color: #fff;">
                                        <tr>
                                            <th> Sku</th>
                                            <th> product id</th>
                                            <th> name</th>

                                            <th> color id</th>
                                            <th> size</th>
                                            <th> original price</th>
                                            <th>warranty month</th>
                                            <th>quantities</th>


                                            <th> is delete</th>

                                            <th> Action</th>
                                            {{-- 'sku', 'product_id', 'name', 'description', 'color_id', 'size', 'original_price', 'warranty_month', 'quantities', 'is_deleted'--}}
                                        </tr>
                                        </thead>
                                        <tbody id="detail_discount_table">
                                        @foreach ($product as $detail_product)
                                            <tr>
                                                <td> {{$detail_product->sku}} </td>
                                                <td> {{$detail_product->product_id}} </td>
                                                <td> {{$detail_product->name}} </td>
                                                <td> {{$detail_product->color_id}} </td>
                                                <td> {{$detail_product->size}} </td>
                                                <td> {{$detail_product->original_price}} </td>
                                                <td> {{$detail_product->warranty_month}} </td>
                                                <td> {{$detail_product->quantities}} </td>
                                                <td> {{$detail_product->is_deleted}} </td>


                                                <td>


                                                    <input type="checkbox" id="regist-{{ $detail_product->sku}}"
                                                           name="registDiscount[{{ $detail_product->sku }}]"
                                                           value="{{ $detail_product->sku }}" class="regist-checkbox"
                                                           {{ in_array($detail_product->sku, $Registor->toArray()) ? 'checked' : '' }} data-product-id="{{ $detail_product->product_id }}"
                                                           data-discount-id="{{$discount->discount_id}}"
                                                           data-sku={{$detail_product->sku }} onchange="sendCheckboxChange(this)" />


                                                </td>


                                            </tr>

                                        @endforeach



                                        {{--                                    test--}}


                                        {{--                                    endtest--}}

                                        </tbody>

                                    </table>
                                                                    <div class="modal-footer"  style="position: sticky; bottom: 0; z-index: 1; background-color: #fff;">

                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                    </div>

                                </form>

                            </div>



                        </div>
                    </div>
                </div>
                @include('admin.components.footer')


            </div>
            {{-- Modal --}}
            @include('admin.components.delete_confirm_modal')
            {{-- Script --}}
            <script src="{{ asset('js/product_api.js') }}" defer></script>
            <script src="{{ asset('js/jquery.min.js') }}"></script>


            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

            <script>
                var x = 0;
                $(document).ready(function() {
                    $('div').scroll(function() {
                        $('span').text(x += 1);
                    });
                });
            </script>

            <script>
                $(document).ready(function() {

                    $('#update-discount-product-form').submit(function(event) {
                        event.preventDefault(); // Prevent the default form submission


                        var checkedProducts = $('.regist-checkbox:checked').map(function() {
                            return {
                                sku: $(this).data('sku'),
                                productId: $(this).data('product-id'),
                                discountId: $(this).data('discount-id'),
                            };
                        }).get();

                        var uncheckedProducts = $('.regist-checkbox:not(:checked)').map(function() {
                            return {
                                sku: $(this).data('sku'),
                                productId: $(this).data('product-id'),
                                discountId: $(this).data('discount-id'),
                            };
                        }).get();
                        console.log('Chon');
                        console.log(checkedProducts);
                        console.log('Bo Chon');
                        console.log(uncheckedProducts);
                        $.ajax({
                            url: '{{route('save_discount_changes')}}',
                            method: 'POST',
                            data: {
                                checkedProducts: checkedProducts,
                                uncheckedProducts: uncheckedProducts,

                                _token: "{{ csrf_token() }}",
                            },


                            success: function(response) {
                                // Handle success response
                                console.log(response);
                                // Optionally, you can show a success message or redirect the user
                            },
                            error: function(xhr, status, error) {
                                // Handle error response
                                console.error(error);
                                // Optionally, you can show an error message
                            },
                        });
                    });
                });
            </script>
            <script>
                $(document).ready(function() {

                    function clear_icon() {
                        $('#id_icon').html('');
                        $('#post_title_icon').html('');
                    }

                    function fetch_data(page, sort_type, sort_by, query) {
                        $.ajax({
                            url: '/pagination/fetch_data?page=' + page + '&sortby=' + sort_by + '&sorttype=' + sort_type + '&query=' + query,
                            success: function(data) {
                                $('tbody').html('');
                                $('tbody').html(data);
                            },
                        });
                    }

                    $(document).on('keyup', '#serach', function() {
                        var query = $('#serach').val();
                        var column_name = $('#hidden_column_name').val();
                        var sort_type = $('#hidden_sort_type').val();
                        var page = $('#hidden_page').val();
                        fetch_data(page, sort_type, column_name, query);
                    });

                    $(document).on('click', '.sorting', function() {
                        var column_name = $(this).data('column_name');
                        var order_type = $(this).data('sorting_type');
                        var reverse_order = '';
                        if (order_type == 'asc') {
                            $(this).data('sorting_type', 'desc');
                            reverse_order = 'desc';
                            clear_icon();
                            $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
                        }
                        if (order_type == 'desc') {
                            $(this).data('sorting_type', 'asc');
                            reverse_order = 'asc';
                            clear_icon;
                            $('#' + column_name + '_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
                        }
                        $('#hidden_column_name').val(column_name);
                        $('#hidden_sort_type').val(reverse_order);
                        var page = $('#hidden_page').val();
                        var query = $('#serach').val();
                        fetch_data(page, reverse_order, column_name, query);
                    });

                    $(document).on('click', '.pagination a', function(event) {
                        event.preventDefault();
                        var page = $(this).attr('href').split('page=')[1];
                        $('#hidden_page').val(page);
                        var column_name = $('#hidden_column_name').val();
                        var sort_type = $('#hidden_sort_type').val();

                        var query = $('#serach').val();

                        $('li').removeClass('active');
                        $(this).parent().addClass('active');
                        fetch_data(page, sort_type, column_name, query);
                    });

                });
            </script>


            <script>
                $(document).ready(function(){
                    $("#search").on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $("#detail_discount_table tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
            </script>

@endsection
