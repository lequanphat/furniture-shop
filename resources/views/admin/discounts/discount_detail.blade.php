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
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
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
                                    <input id="title" name="title" type="text" class="form-control" placeholder="High quality plastic tables and chairs" value="{{$discount->title}}" readonly>
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


                                    <input id="active" name="active" class="form-control" type="text" value="{{ $discount->is_active === 0 ? 'Off' : 'On' }}" readonly>


                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">start Date</label>

                                    <input class="form-control" type="date" id="startdate" name="startdate" value="{{$discount->start_date}}">

                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label for="category" class="form-label">end Date</label>

                                    <input class="form-control" type="date" id="enddate" name="enddate" value="{{$discount->end_date }}">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label for="brand" class="form-label">Percentage</label>
                                    <input class="form-control" type="number" id="percentage" name="percentage" min="0" max="100 " value="{{$discount->percentage}}">
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
                        <div class="table-responsive" style="overflow:scroll;">
                            <form id="update-discount-product-form" action="#" method="POST">
                                @csrf
                                <table class="js-user-table table table-vcenter card-table ">
                                    <thead>
                                        <tr>
                                            <th> Sku</th>
                                            <th> product id</th>
                                            <th> name</th>

                                            <th> color id</th>
                                            <th> size</th>
                                            <th> original price</th>
                                            <th>warranty month</th>
                                            <th>quantities </th>


                                            <th> is delete</th>

                                            <th> Action</th>
                                            {{-- 'sku', 'product_id', 'name', 'description', 'color_id', 'size', 'original_price', 'warranty_month', 'quantities', 'is_deleted'--}}
                                        </tr>
                                    </thead>
                                    <tbody>
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



                                                <input type="checkbox" id="regist-{{ $detail_product->sku}}" name="registDiscount[{{ $detail_product->sku }}]" value="{{ $detail_product->sku }}" class="regist-checkbox" {{ in_array($detail_product->sku, $Registor->toArray()) ? 'checked' : '' }} data-product-id="{{ $detail_product->product_id }}" data-discount-id="{{$discount->discount_id}}" data-sku={{$detail_product->sku }} onchange="sendCheckboxChange(this)" />


                                            </td>



                                        </tr>
                                        @endforeach


                                    </tbody>

                                </table>
                                <div class="modal-footer">
                                  
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

        <!-- <script>
             


                function sendCheckboxChange(checkbox) {
                    const productId = checkbox.dataset.productId;
                    const isChecked = checkbox.checked;
                    const discount_id = checkbox.dataset.discountId;
                    const sku =checkbox.dataset.sku;
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');
                    // const a=[productId,isChecked,discount_id];
                  // Get token from meta tag
              
                    if (isChecked) {
                        
                        $(window).on('load',function()
                        {
                            $('#delete-confirm-modal').modal('show')
                        });
                       
                     
                $('#confirm-btn').on('click', function() {
                        $.ajax({
                            url: '{{ route('product.Discount.checkbox') }}', // Replace with actual route name
                            method: 'POST',
                            data: {
                                product_id: productId,
                                is_checked: isChecked,
                                discount_id: discount_id
                                ,
                                sku:sku,
                                _token: csrfToken, // Include the CSRF token
                            },
                            success: function(data) {
                                // Handle successful response (optional)
                                // console.log('Checkbox change sent successfully:', data);
                                if (data.message === 'Checkbox change saved successfully') {
                                    // Handle successful update
                                    console.log(data.message);
                                } else if (data.message === 'Khong Ton Tai SKU Cua San Pham Vui Long Them') {
                                    // Display popup message
                                    alert(data.message); // Replace with your preferred popup mechanism
                                    $(checkbox).prop("checked", false);

                                }
                            },
                            error: function(error) {
                                console.error('Error sending checkbox change:', error);

                            },
                        });
                    });

                    }
                    else
                    {
                        $.ajax({
                            url: '{{ route('delete.ProductDiscount.checkbox') }}', // Replace with actual route name
                            method: 'POST',
                            data: {
                                product_id: productId,
                                is_checked: isChecked,
                                discount_id: discount_id,
                                sku:sku,
                                _token: csrfToken, // Include the CSRF token
                            },
                            success: function(data) {
                                // Handle successful response (optional)
                                console.log('Checkbox change sent successfully:', data);
                            },
                            error: function(error) {
                                console.error('Error sending checkbox change:', error);

                            },
                        });


                    }
                }
            </script> -->
        {{-- scroll--}}
        <script>
            var x = 0;
            $(document).ready(function() {
                $("div").scroll(function() {
                    $("span").text(x += 1);
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
                            discountId: $(this).data('discount-id')
                        };
                    }).get();

                    var uncheckedProducts = $('.regist-checkbox:not(:checked)').map(function() {
                        return {
                            sku: $(this).data('sku'),
                            productId: $(this).data('product-id'),
                            discountId: $(this).data('discount-id')
                        };
                    }).get();
                    console.log("Chon");
                    console.log(checkedProducts);
                    console.log("Bo Chon");
                    console.log(uncheckedProducts);
                    $.ajax({
                        url: '{{route('save_discount_changes')}}',
                        method: 'POST',
                        data: {
                            checkedProducts: checkedProducts,
                            uncheckedProducts: uncheckedProducts,

                            _token: "{{ csrf_token() }}"
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
                        }
                    });
                });
            });
        </script>




        @endsection