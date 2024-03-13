@extends('layouts.admin')
@section('content')
    <h1>Cập nhật Supplier</h1>

    <form action="{{ route('Suppliers.update',$Supplier->Supplier_id) }}" method="PUT">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên Supplier</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $Supplier->name }}">
            @error('name')
            <div class="text-danger">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Mô tả Supplier</label>
            <textarea name="description" id="description" class="form-control">{{ $Supplier->description }}</textarea>
            @error('name')
            <div class="text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
        <label for="index">Index :</label>
        <input type="number" name="index" id="index" class="form-control" value="{{ $Supplier->index }}">
        @error('index')
            <div class="text-danger">{{$message}}</div>
        @enderror
    </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection

