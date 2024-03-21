@extends('layouts.empty')
@section('content')
    <form id="account-verify-form" action="/account-verification/{{ $user->user_id }}" method="POST" class="card card-md"
        data-user-id="{{ $user->user_id }}">
        @csrf
        <div class="card-body">
            <h2 class="card-title card-title-lg text-center mb-4">Authenticate Your Account</h2>
            <p class="my-4 text-center">Please confirm your account by entering the authorization code sent to
                <strong>{{ $user->email }}
                </strong>.
            </p>
            <div class="my-5">
                <div class="row g-4">
                    <div class="col">
                        <div class="row g-2">
                            <div class="col">
                                <input type="text" class="input-field form-control form-control-lg text-center py-3"
                                    maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input="">
                            </div>
                            <div class="col">
                                <input type="text" class="input-field form-control form-control-lg text-center py-3"
                                    maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input="">
                            </div>
                            <div class="col">
                                <input type="text" class="input-field form-control form-control-lg text-center py-3"
                                    maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input="">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row g-2">
                            <div class="col">
                                <input type="text" class="input-field form-control form-control-lg text-center py-3"
                                    maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input="">
                            </div>
                            <div class="col">
                                <input type="text" class="input-field form-control form-control-lg text-center py-3"
                                    maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input="">
                            </div>
                            <div class="col">
                                <input type="text" class="input-field form-control form-control-lg text-center py-3"
                                    maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p id="js-account-verify-response" class="text-danger m-0"></p>
            <div class="form-footer">
                <div class="btn-list flex-nowrap">
                    <a href="/login" class="btn w-100">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-success w-100">
                        Verify
                    </button>
                </div>
            </div>
        </div>
    </form>



    <div class="text-center text-secondary mt-3">
        It may take a minute to receive your code. Haven't received it? <a href="/resend-otp/{{ $user->user_id }}">Resend a
            new code.</a>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}" defer></script>
    <script src="{{ asset('js/auth_api.js') }}" defer></script>
@endsection
