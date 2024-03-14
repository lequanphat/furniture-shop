@extends('layouts.admin')
@section('content')
<h1>Tạo mới Supplier</h1>
<form action="{{ route('Suppliers.store') }}"  method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Tên :</label>
        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
        @error('name')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Mô tả :</label>
        <input type="text" name="description" id="description" class="form-control" value="{{old('description')}}">
        @error('description')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="address">Address :</label>
        <input type="text" name="address" id="address" class="form-control" value="{{old('address')}}">
        @error('address')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="phone_number">Phone :</label>
        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{old('phone_number')}}">
        @error('phone_number')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary"> Tạo mới</button>
</form>
@endsection