@extends('layouts.empty')
@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Authenticate Your Account</h2>
            <p class="text-muted mb-4">Please confirm your account by entering the code sent to your email. </p>
            <form action="/account-verification/{{ $user_id }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="otp" class="form-label">OTP Code</label>
                    <input type="text" name="otp" id="otp" value="{{ old('otp') }}" class="form-control"
                        placeholder="6 digits">
                </div>
                @if ($errors->any())
                    <p class="text-danger m-0">*{{ $errors->all()[0] }}</p>
                @endif
                <button type="submit" class="btn btn-primary container-fluid mt-4">SUBMIT</button>
                <p class="m-0 mt-3 text-center">You didn't receive the code?
                    <a class="text-primary" href="/resend-otp/{{ $user_id }}">Send again</a>
                </p>
            </form>
        </div>
    </div>
@endsection
