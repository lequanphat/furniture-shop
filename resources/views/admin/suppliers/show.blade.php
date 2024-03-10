@extends('layouts.admin')
@section('content')
<h1>Xem chi tiết Brand</h1>

<div class="card">
    <div class="card-header">
        {{ $supplier->name }}
    </div>
    <div class="card-body">
        <p>{{ $supplier->description }}</p>
        <p>Thứ tự: {{ $supplier->index }}</p>
    </div>
</div>

<a href="{{ route('suppliers.index') }}">Quay lại</a>
@endsection