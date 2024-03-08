@extends('layouts.empty')
@section('content')
    <div class="container rounded bg-white p-4 " style="width: 400px;">
        <h1 class='text-center fs-4'>CHANGE PASSWORD</h1>
        <form action="/change-password" method="post">
            @csrf
            <label for="password" class="mt-2 ">Password:</label>
            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control" required>
            <label for="confirm_password" class="mt-2 ">Confirm password:</label>
            <input type="password" name="confirm_password" id="confirm_password" value="{{ old('confirm_password') }}"
                class="form-control mb-4" required>
            @if ($errors->any())
                <p class="text-danger m-0">*{{ $errors->first() }}</p>
            @endif

            <button type="submit" class="btn btn-primary container-fluid ">SUBMIT</button>
            <p class="m-0 mt-3 text-center">Go to dashboard? <a class="text-primary" href="/">Dashboard</a>
            </p>
        </form>
    </div>
@endsection
