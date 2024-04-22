@extends('layouts.empty')
@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Login to your account</h2>
            <form id="login-form" action="#" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control"
                        placeholder="your@email.com" autocomplete="off" required>
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">
                        Password
                        <span class="form-label-description">
                            <a href="/forgot-password">I forgot password</a>
                        </span>
                    </label>
                    <div class="input-group input-group-flat mb-4">
                        <input type="password" name="password" id="password" value="{{ old('password') }}"
                            class="form-control" placeholder="Your password" autocomplete="off" required>
                        <span class="input-group-text">
                            <a href="#" class="link-secondary" title="Show password"
                                data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path
                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                </svg>
                            </a>
                        </span>
                    </div>
                </div>
                <p id="js-login-error" class="text-danger m-0 d-none"></p>
                <div class="form-footer mt-2">
                    <button type="submit" class="btn btn-success w-100">Sign in</button>
                </div>
            </form>
        </div>
        <div class="hr-text">or</div>
        <div class="card-body">
            <div class="row">
                <div class="col"><a href="{{ route('google.login') }}" class="btn w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#a4b904" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-google">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M20.945 11a9 9 0 1 1 -3.284 -5.997l-2.655 2.392a5.5 5.5 0 1 0 2.119 6.605h-4.125v-3h7.945z" />
                        </svg>
                        Login with Google
                    </a></div>
                <div class="col">
                    <a href="{{ route('facebook.login') }}" class="btn w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#2490f5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                        </svg>
                        Login with Facebook
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center text-muted mt-3">
        Don't have account yet? <a href="/register" tabindex="-1">Sign up</a>
    </div>
@endsection
