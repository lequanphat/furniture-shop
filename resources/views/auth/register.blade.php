@extends('layouts.empty')
@section('content')
    <form id="register-form" class="card card-md" action="#" autocomplete="off">
        @csrf
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Create new account</h2>
            <div class="mb-3">
                <label class="form-label">First name</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control"
                    placeholder="Cristiano">
            </div>
            <div class="mb-3">
                <label class="form-label">Last name</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control"
                    placeholder="Ronaldo">
            </div>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control"
                    placeholder="Enter email">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group input-group-flat mb-4">
                    <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control"
                        placeholder="Password" autocomplete="off">
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
            <p id="js-register-error" class="text-danger m-0 "></p>
            <div class="form-footer mt-2">
                <button type="submit" class="btn btn-success w-100">Create new account</button>
            </div>

        </div>
    </form>

    <div class="text-center text-muted mt-3">
        Already have account? <a href="/login" tabindex="-1">Sign in</a>
    </div>
@endsection
