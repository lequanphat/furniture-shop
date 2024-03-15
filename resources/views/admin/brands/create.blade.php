@extends('layouts.admin')
@section('content')
<h1>Tạo mới Brand</h1>
<button onclick="history.back()" type="button" class="btn btn-primary">Quay lại</button>
<form action="{{ route('brands.store') }}"  method="POST">
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
        <label for="index">Index :</label>
        <input type="number" name="index" id="index" class="form-control" value="{{old('name')}}">
        @error('index')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary"> Tạo mới</button>
</form>
@endsection