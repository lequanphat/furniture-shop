@extends('layouts.admin')
@section('content')
    <section id="main-content">
        <form action="{{route('Suppliers.search')}}" method="GET">
        <input type="text" name="keyword" id="keyword" placeholder="Tìm kiếm Supplier">
        <button type="submit">Tìm kiếm</button>
        </form>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Index</th>
                <th><th>
            </tr>
            </thead>
            <tbody>
            @if (isset($Suppliers) && count($Suppliers) > 0)
    @foreach ($Suppliers as $Supplier)
    <tr>
                        <td>{{$Supplier->Supplier_id}}</td>
                        <td>{{$Supplier->name}}</td>
                        <td>{{$Supplier->index}}</td>
                   
                        <td><a href="{{ route('Suppliers.show', $Supplier->Supplier_id) }}" class="btn btn-warning">Xem</a>
                        <a href="{{ route('Suppliers.edit', $Supplier->Supplier_id) }}" class="btn btn-warning">Sửa</a></td>
    </tr>
    @endforeach
    @else
    <p>Không có Supplier nào.</p>
    @endif
            </tbody>
        </table>
        <a class="btn btn-primary" href="{{route('Suppliers.create')}}" class>Tạo</a>
        @include('admin.components.footer')
    </section>
@endsection
