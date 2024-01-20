@extends('layouts.app')
@section('content')
    <h1>dashboard</h1>
    <h1>{{ session('user') }}</h1>

    <form action="/logout">
        <button type="submit">Logout</button>
    </form>
@endsection