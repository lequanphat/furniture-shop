@extends('layouts.empty')
@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Change your password</h2>
            <form action="{{ route('change_password') }}" method="POST" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group input-group-flat">
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
                <div class="mb-2">
                    <label for="new_password" class="form-label">
                        New Password
                    </label>
                    <div class="input-group input-group-flat">
                        <input type="password" name="new_password" id="new_password" value="{{ old('new_password') }}"
                            class="form-control" placeholder="Your new password" autocomplete="off" required>
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
                @if ($errors->any())
                    <p class="text-danger m-0">*{{ $errors->first() }}</p>
                @endif
                <div class="form-footer">
                    <button type="submit" class="btn btn-success w-100">Change password</button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center text-muted mt-3">
        Forget it, <a href="/" tabindex="-1">send me back</a> to the dashboard.
    </div>
@endsection
