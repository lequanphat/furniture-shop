@extends('layouts.admin')
@section('content')
    <h1>Cập nhật supplier</h1>
    <button onclick="history.back()" type="button" class="btn btn-primary">Quay lại</button>
    <form action="{{ route('suppliers.update',$supplier->supplier_id) }}" method="PUT">
    @csrf
    <div class="form-group">
        <label for="supplier_id">Tên :</label>
        <input type="text" name="supplier_id" id="supplier_id" class="form-control" value="{{$supplier->supplier_id}}" readonly>
        @error('supplier_id')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="name">Tên :</label>
        <input type="text" name="name" id="name" class="form-control" value="{{$supplier->name}}">
        @error('name')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Mô tả :</label>
        <input type="text" name="description" id="description" class="form-control" value="{{$supplier->description}}">
        @error('description')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="address">Address :</label>
        <input type="text" name="address" id="address" class="form-control" value="{{$supplier->address}}">
        @error('address')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="phone_number">Phone :</label>
        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{$supplier->phone_number}}">
        @error('phone_number')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary"> Cập nhật</button>
</form>
@endsection

