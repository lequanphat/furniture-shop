@extends('layouts.empty')
@section('content')
    <div class="container rounded bg-white p-4 " style="width: 400px;">
        <h1 class='text-center fs-4'>EMAIL VERIFICATION</h1>
        <form action="/forgot-password-verification/{{ $user_id }}" method="post">
            @csrf
            <label for="otp" class="mt-2 ">OTP</label>
            <input type="text" name="otp" id="otp" value="{{ old('otp') }}" class="form-control mb-2" required>
            @if ($errors->any())
                <p class="text-danger m-0">*{{ $errors->all()[0] }}</p>
            @endif
            <button type="submit" class="btn btn-primary container-fluid mt-4">SUBMIT</button>
            <p class="m-0 mt-3 text-center">You didn't receive the code?
                <a class="text-primary" href="/resend-otp/{{ $user_id }}">Send again</a>
            </p>
        </form>
    </div>
@endsection
