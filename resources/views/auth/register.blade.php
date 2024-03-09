@extends('layouts.empty')
@section('content')
    <div class="container rounded bg-white p-4 " style="width: 400px;">
        <h1 class='text-center fs-2'>REGISTER</h1>
        <form action="/register" method="post">
            @csrf
            <label for="first_name" class="mt-2 ">First name:</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control"
                required>
            <label for="last_name" class="mt-2 ">Last name:</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control"
                required>
            <label for="email" class="mt-2">Email:</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
            <label for="password" class="mt-2">Password:</label>
            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control mb-4"
                required>
            @if ($errors->any())
                <p class="text-danger m-0">*{{ $errors->first() }}</p>
            @endif
            <button type="submit" class="btn btn-primary container-fluid">REGISTER</button>
            <p class="m-0 mt-3 text-center">You have already an account? <a class="text-primary" href="/login">Login</a>
            </p>
        </form>
    </div>
@endsection
