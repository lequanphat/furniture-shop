@extends('layouts.empty')
@section('content')
    <div class="container rounded bg-white p-4 " style="width: 400px;">
        <h1 class='text-center fs-2'>REGISTER</h1>
        <form action="/register" method="post">
            @csrf
            <label for="displayName" class="mt-2 ">Display name:</label>
            <input type="text" name="displayName" id="displayName" value="{{ old('displayName') }}" class="form-control">
            <label for="email" class="mt-2">Email:</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control">
            <label for="password" class="mt-2">Password:</label>
            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control mb-4">
            @if ($errors->any())
                <p class="text-danger">*{{ $errors->all()[0] }}</p>
            @endif
            <button type="submit" class="btn btn-primary container-fluid">REGISTER</button>
            <p class="mt-4 text-center">You already have an account? <a class="text-primary" href="/login">Login</a>
            </p>
        </form>
    </div>
@endsection
