@extends('layouts.app')
@section('content')
    @include('components.hero-section')
    <!-- Start Why Choose Us Section -->
    @include('components.why-choose')
    <!-- End Why Choose Us Section -->

    @include('pages.about.team')



    
@endsection
