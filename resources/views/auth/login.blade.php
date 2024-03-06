@extends('layouts.empty')
@section('content')
    <div class="container rounded bg-white p-4 " style="width: 400px;">
        <h1 class='text-center fs-2'>LOGIN</h1>
        <form action="/login" method="post">
            @csrf
            <label for="email" class="mt-2 ">Email:</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control">
            <label for="password" class="mt-2 ">Password:</label>
            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control mb-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif
            <button type="submit" class="btn btn-primary container-fluid">LOGIN</button>
            <p class="mt-4 text-center">You don't have an account? <a class="text-primary" href="/register">Register</a>
            </p>
        </form>
    </div>
@endsection
