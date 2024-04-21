@extends('layouts.admin')
@section('content')
    <section id="main-content">
     
    <div class="card">
    <div class="card-body">
    <h1 id="title_chart">Overview 7 day</h1>
    <div id="chart-statistic" class="chart-lg"></div>
    </div>
    </div>
    <div class="container">
    <form class="row" id="statistic_form">
        @csrf
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
          <input type="date" id="start-date" name="start-date" required class="form-control">
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label for="end-date">End Date:</label>
          <input type="date" id="end-date" name="end-date" required class="form-control">
        </div>
      </div>

      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    <div class="card">
    <div class="card-body">
    <h1 id="title_chart">Result</h1>
    <div id="chart-statistic-2" class="chart-lg"></div>
    </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
    <script src="{{ asset('js/statistic_api.js') }}" defer></script>

        @include('admin.components.footer')
        
    </section>
    
@endsection
