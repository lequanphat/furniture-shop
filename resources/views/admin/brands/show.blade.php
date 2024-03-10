@extends('layouts.admin')
@section('content')
<h1>Xem chi tiết Brand</h1>

<div class="card">
    <div class="card-header">
        {{ $brand->name }}
    </div>
    <div class="card-body">
        <p>{{ $brand->description }}</p>
        <p>Thứ tự: {{ $brand->index }}</p>
    </div>
</div>

<a href="{{ route('brands.index') }}">Quay lại</a>
@endsection