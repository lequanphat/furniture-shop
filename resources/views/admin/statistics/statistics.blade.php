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
                            {{ $page }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body mb-2">
            <div class="container-xl ">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h1 id="title_chart">Overview 7 days lately</h1>
                                <div id="chart-statistic" class="chart-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br>

            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <form class="row justify-content-end" id="statistic_form">
                                @csrf
                                <div class="card-body">
                                    <h1 id="title_chart">Product</h1>
                                    <div class="row row-cards">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="combobox-categories">Category:</label>
                                                <select id="combobox-categories" name="category_id" class="form-control">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="start-date">Start Date:</label>
                                                <input type="date" id="start-date" name="start-date" required
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="end-date">End Date:</label>
                                                <input type="date" id="end-date" name="end-date" required
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-xl ">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h1 id="title_chart">Result</h1>
                                <div id="chart-statistic-2" class="chart-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br>




            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-auto">
                        <div class="card">
                            <div class="row justify-content-end">
                                <div class="card-body" >

                                    {{-- dòng filter --}}
                                    <div class="row row-cards" >
                                        <h1 id="title_chart">Filter product sales</h1>
                                        <div class="col-auto row ">
                                            <div class="col-6">
                                                <input id="search_first_pc" name="search_first_pc" class="col-6 form-control"
                                                    type="date" value="" title="Start date">
                                            </div>
                                            <div class="col-6">
                                                <input id="search_last_pc" name="search_last_pc" class="col-6 form-control" type="date"
                                                    value="" title="End date">
                                            </div>
                                        </div>
                                        <div class="col-auto row">
                                            <select id="time_frame_pc" name="time_frame_pc" class="form-select" title="Choose type">
                                                <option value="1w" >Last week</option>
                                                <option value="1m" >Last 1 months</option>
                                                <option value="3m" >Last quarter</option>
                                                <option value="1y" >Last year</option>
                                            </select>
                                        </div>
                                        {{-- <div class="col-auto row">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div> --}}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-xl ">
                <div class="row row-deck row-cards">
                    <div class="col-lg-10 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 id="title_chart">Selling product</h3>
                                <div id="chart-demo-pie"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-10 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 id="title_chart">Selling by product types</h3>
                                <div id="chart-demo-pie-type-product"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>


        </div>



        @include('admin.components.footer')
        @include('admin.components.error_delete_modal')
        <script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('js/statistic_api.js') }}" defer></script>
    </section>
@endsection
