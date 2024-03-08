@extends('layouts.empty')
@section('content')
    <div class="container rounded bg-white p-4 " style="width: 400px;">
        <h1 class='text-center fs-2'>LOGIN</h1>
        <form action="/login" method="post">
            @csrf
            <label for="email" class="mt-2 ">Email:</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
            <label for="password" class="mt-2 ">Password:</label>
            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control mb-4"
                required>
            @if ($errors->any())
                <p class="text-danger m-0">*{{ $errors->first() }}</p>
            @endif

            <button type="submit" class="btn btn-primary container-fluid ">LOGIN</button>
            <p class="text-center my-2"><a class="text-primary " href="/forgot-password">Forgot password</a></p>
            <div class="border-top-1px my-3"></div>
            <p class="m-0 text-center">You don't have an account? <a class="text-primary" href="/register">Register</a>
            </p>
        </form>
    </div>
@endsection
