@extends('layouts.empty')
@section('content')
    <div class="container rounded bg-white p-4 " style="width: 400px;">
        <h1 class='text-center fs-4 '>FORGOT PASSWORD</h1>
        <p class="m-0 mt-3">Enter the email associated with your account, we will send a confirmation code to your email.</p>
        <form action="/forgot-password" method="post">
            @csrf
            <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="example@gmail.com"
                class="form-control mt-1 mb-3" required>
            @if ($errors->any())
                <p class="text-danger m-0">*{{ $errors->first() }}</p>
            @endif
            <button type="submit" class="btn btn-primary container-fluid ">SUBMIT</button>
            <p class="m-0 mt-3 text-center">Return to login? <a class="text-primary" href="/login">Login</a>
            </p>
        </form>
    </div>
@endsection
