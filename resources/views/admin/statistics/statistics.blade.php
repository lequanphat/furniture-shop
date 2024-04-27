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
                                <h1 id="title_chart">Overview 7 day</h1>
                                <div id="chart-statistic" class="chart-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

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
            </div>
        </div>



        @include('admin.components.footer')
        <script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('js/statistic_api.js') }}" defer></script>
    </section>
@endsection
