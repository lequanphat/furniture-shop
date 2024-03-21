@extends('layouts.admin')
@section('content')
    <h1>Brand detail</h1>
    <a href="{{ route('brands.index', $brand->brand_id) }}" class="btn btn-warning">Sửa</a></td>
    <form>
        <div class="form-group">
            <label for="id"> Mã Brand</label>
            <input type="text" name="id" id="id" class="form-control" value="{{ $brand->brand_id }}" readonly>
            <label for="name">Tên brand</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $brand->name }}" readonly>
            @error('name')
            <div class="text-danger">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Mô tả brand</label>
            <textarea name="description" id="description" class="form-control" readonly>{{ $brand->description }}</textarea>
            @error('name')
            <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
        <label for="index">Index :</label>
        <input type="number" name="index" id="index" readonly class="form-control" value="{{ $brand->index }}">
        @error('index')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
    </form>
@endsection
