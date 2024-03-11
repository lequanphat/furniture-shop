@extends('layouts.app')
@section('content')
    <div class="container py-5 d-flex justify-content-center">
        <div class="d-flex align-items-center rounded bg-white p-5" style="width: 600px;flex-direction: column">
            <h2>My account</h2>
            <img src="{{ Auth::user()->avatar }}" alt="avatar" class="rounded-circle my-4"
                style="width: 120px; height: 120px;" />
            <button class="d-block btn btn-primary px-4 mx-1 mb-4">Chọn ảnh</button>
            <form id="update-employee-form" action="#" method="dialog" style="width: 100%">
                @csrf
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="{{ Auth::user()->first_name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="{{ Auth::user()->last_name }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                            required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                            required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ Auth::user()->email }}" readonly>

                </div>
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Birth Date</label>
                    <input type="date" class="form-control" id="birth_date" name="birth_date"
                        value="{{ Auth::user()->birth_date }}" required>
                </div>
                <div><button type="submit" class="btn btn-primary px-5 mt-2 mb-5" style="float: right;">Save</button></div>
            </form>

        </div>
    </div>
@endsection
