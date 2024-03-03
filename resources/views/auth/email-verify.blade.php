@extends('layouts.empty')
@section('content')
    <div class="container rounded bg-white p-4 " style="width: 400px;">
        <h1 class='text-center fs-2'>EMAIL VERIFY</h1>
        <form action="/email-verify/{{ $user_id }}" method="post">
            @csrf
            <label for="otp" class="mt-2 ">OTP</label>
            <input type="text" name="otp" id="otp" value="{{ old('otp') }}" class="form-control">
            @if ($errors->any())
                <p class="text-danger m-0">*{{ $errors->all()[0] }}</p>
            @endif
            <button type="submit" class="btn btn-primary container-fluid mt-4">LOGIN</button>
            <p class="mt-4 text-center">You didn't receive the code? <a class="text-primary" href="#">Send again</a>
            </p>
        </form>
    </div>
@endsection
