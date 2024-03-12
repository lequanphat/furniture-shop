@extends('layouts.admin')
@section('content')
    <section id="main-content">
        <div class="row">
            <div class="col-lg-6 ">
                <h5>The list of Categories</h5>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-end ">
                    <button id="js-create-category-btn" type="button" class="btn btn-primary mr-2"
                    >
                        <span class=" mr-1">CREATE</span>
                        <i class="ti-plus"></i>
                    </button>
                    <button type="button" class="btn btn-primary mr-2">
                        <i class="ti-reload"></i>
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
                                    <th>Categor_id</th>
                                    <th>name</th>
                                    <th>description</th>
                                    <th>index</th>
                                    <th>parent_id</th>

                                </tr>
                                </thead>
                                <tbody id="employee-table">
                                @foreach ($categories as $category)

                                    <tr>
                                        <td>{{ $category->category_id }}</td>

                                        <td>{{$category->name}}</td>
                                        <td>
                                            {{$category->description}}
                                        </td>
                                        <td> {{$category->index}}</td>
                                        <td>{{$category->parent_id}}</td>
                                        {{-- temporary value --}}


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
        <h1>This is categories page</h1>
        @include('admin.categories.create_category')
        @include('admin.components.footer')
    </section>
@endsection
