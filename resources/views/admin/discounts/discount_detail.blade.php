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
                        {{-- <a href="{{ route('products.index') }}" class="btn">--}}
                        {{-- Back--}}
                        {{-- </a>--}}

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
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">amount</label>
                                        <input id="amount" name="amount" class="form-control" type="text"
                                               value="{{$discount->amount}}" readonly>


                                    </div>
                                </div>
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

                                <div class="col-md-12">
                                    <div class="mb-3 mb-0">
                                        <label class="form-label">Description</label>
                                        <textarea id="update_editor" name="description"
                                                  value="{!!$discount->description!!}"></textarea>
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
                            <div class="table-responsive">
                                <table class="js-user-table table table-vcenter card-table">
                                    <thead>
                                    <tr>
                                        <th> product</th>
                                        <th> name</th>
                                        <th>description</th>
                                        <th> category</th>
                                        <th> Quantities</th>
                                        <th>brand id</th>
                                        <th> is delete</th>

                                        <th> Action</th>
                                        <!-- 'name', 'description', 'category_id', 'quantities', 'brand_id', 'is_deleted' -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($product as $detail_product)
                                        <tr>
                                            <td> {{$detail_product->product_id}} </td>
                                            <td> {{$detail_product->name}} </td>
                                            <td> {{$detail_product->description}} </td>
                                            <td> {{$detail_product->category_id}} </td>
                                            <td> {{$detail_product->quantities}} </td>
                                            <td> {{$detail_product->brand_id}} </td>
                                            <td> {{$detail_product->is_deleted}} </td>



                                            <td>
                                                <input type="checkbox" id="regist-{{ $detail_product->product_id }}"
                                                       name="registDiscount[{{ $detail_product->product_id }}]"
                                                       value="{{ $detail_product->product_id }}" class="regist-checkbox"
                                                    {{ in_array($detail_product->product_id, $Registor->toArray()) ? 'checked' : '' }}

                                                />
                                            </td>

{{--<td>--}}
{{--    <input type="hidden" id="regist-{{ $detail_product->product_id }}_hidden" name="registDiscountHidden[{{ $detail_product->product_id }}]" value="0">--}}
{{--    <input type="checkbox" id="regist-{{ $detail_product->product_id }}"--}}
{{--           name="registDiscount[{{ $detail_product->product_id }}]"--}}
{{--           value="{{ $detail_product->product_id }}" class="regist-checkbox"--}}
{{--           {{ in_array($detail_product->product_id, $Registor->toArray()) ? 'checked' : '' }}--}}
{{--           onclick="document.getElementById('regist-{{ $detail_product->product_id }}_hidden').value = this.checked ? 1 : 0" />--}}


{{--</td>--}}

                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end my-2">
                                    {{-- {{ $detaild_products->render('common.pagination') }}
                                </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin.components.footer')
            </div>
            {{-- Modal --}}
            {{-- Script --}}
            <script src="{{ asset('js/product_api.js') }}" defer></script>
@endsection
