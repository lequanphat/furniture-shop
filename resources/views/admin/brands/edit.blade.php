@extends('layouts.admin')
@section('content')
    <h1>Cập nhật brand</h1>
    <a href="{{route("brands.index")}}" class="btn btn-primary">Quay lại</a>
    <form method="POST" action="{{ route('brands.update',$brand->brand_id) }}">
        @csrf
        <div class="form-group">
            <label for="id"> Mã Brand</label>
            <input type="text" name="id" id="id" class="form-control" value="{{ $brand->brand_id }}" readonly>
            <label for="name">Tên brand</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $brand->name }}">
            @error('name')
            <div class="text-danger">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Mô tả brand</label>
            <textarea name="description" id="description" class="form-control">{{ $brand->description }}</textarea>
            @error('name')
            <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
        <label for="index">Index :</label>
        <input type="number" name="index" id="index" class="form-control" value="{{ $brand->index }}">
        @error('index')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection

