@extends('layouts.admin')
@section('content')
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Hello, <span>Welcome Here</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Table-Basic</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Table Basic </h4>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Kolor Tea Shirt For Man</td>
                                                    <td><span class="badge badge-primary">Sale</span></td>
                                                    <td>January 22</td>
                                                    <td class="color-primary">$21.56</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Kolor Tea Shirt For Women</td>
                                                    <td><span class="badge badge-success">Tax</span></td>
                                                    <td>January 30</td>
                                                    <td class="color-success">$55.32</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>Blue Backpack For Baby</td>
                                                    <td><span class="badge badge-danger">Extended</span></td>
                                                    <td>January 25</td>
                                                    <td class="color-danger">$14.85</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Table Striped </h4>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Kolor Tea Shirt For Man</td>
                                                    <td><span class="badge badge-primary">Sale</span></td>
                                                    <td>January 22</td>
                                                    <td class="color-primary">$21.56</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Kolor Tea Shirt For Women</td>
                                                    <td><span class="badge badge-success">Tax</span></td>
                                                    <td>January 30</td>
                                                    <td class="color-success">$55.32</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>Blue Backpack For Baby</td>
                                                    <td><span class="badge badge-danger">Extended</span></td>
                                                    <td>January 25</td>
                                                    <td class="color-danger">$14.85</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Table Bordered </h4>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Kolor Tea Shirt For Man</td>
                                                    <td><span class="badge badge-primary">Sale</span></td>
                                                    <td>January 22</td>
                                                    <td class="color-primary">$21.56</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Kolor Tea Shirt For Women</td>
                                                    <td><span class="badge badge-success">Tax</span></td>
                                                    <td>January 30</td>
                                                    <td class="color-success">$55.32</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>Blue Backpack For Baby</td>
                                                    <td><span class="badge badge-danger">Extended</span></td>
                                                    <td>January 25</td>
                                                    <td class="color-danger">$14.85</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Table Hover </h4>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Kolor Tea Shirt For Man</td>
                                                    <td><span class="badge badge-primary">Sale</span></td>
                                                    <td>January 22</td>
                                                    <td class="color-primary">$21.56</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Kolor Tea Shirt For Women</td>
                                                    <td><span class="badge badge-success">Tax</span></td>
                                                    <td>January 30</td>
                                                    <td class="color-success">$55.32</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>Blue Backpack For Baby</td>
                                                    <td><span class="badge badge-danger">Extended</span></td>
                                                    <td>January 25</td>
                                                    <td class="color-danger">$14.85</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                        <!-- /# column -->
                    </div>
                    <!-- /# row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer">
                                <p>2018 © Admin Board. - <a href="#">example.com</a></p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
