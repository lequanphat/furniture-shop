@extends('layouts.empty')
@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 card-title text-center mb-4">Check your mail</h2>
            <p class="text-muted mb-4">Please check your email to receive the new password provided, use the new password to
                log in and change your password.</p>
            <div class="form-footer">
                <a href="/login" class="btn btn-success w-100">
                    Back to Login
                </a>
            </div>
        </div>
    </div>
    <div class="text-center text-muted mt-3">
        Forget it, <a href="/login">send me back</a> to the sign in screen.
    </div>
@endsection
