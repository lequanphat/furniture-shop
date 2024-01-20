@extends('layouts.empty')
@section('content')
<div class="flex items-center justify-center w-[100vw] h-[100vh]">
    <div class="border-[1px] border-black p-4 mb-5 w-[360px] "> <h1 class='text-center font-semibold mb-5'>LOGIN</h1>
        <form action="/login" method="post">
            @csrf
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}" class="mt-2 border-[1px] border-black p-1 block rounded w-[100%] mb-4"> 
            <label for="password">Password:</label>
            <input type="text" name="password" id="password" value="{{ old('password') }}" class="mt-2 border-[1px] border-black p-1  block rounded w-[100%] mb-4">
            @if ($errors->any())
                <p class="text-red-400">*{{ $errors->all()[0] }}</p>
            @endif
            <button type="submit" class="border-[2px] border-white py-1 px-3 rounded bg-[#0984e3] text-white mt-2 w-[100%]">LOGIN</button>
            <p class="mt-4 text-center">You don't have an account? <a class="text-[#0984e3]" href="/register">Register</a></p>
        </form></div>
    </div>
@endsection
    