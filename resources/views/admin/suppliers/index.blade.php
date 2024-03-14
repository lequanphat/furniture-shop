@extends('layouts.admin')
@section('content')
    <section id="main-content">
        <form action="{{route('Suppliers.search')}}" method="GET">
        <input type="text" name="keyword" id="keyword" placeholder="Tìm kiếm Supplier">
        <button type="submit">Tìm kiếm</button>
        </form>
        <a class="btn btn-primary" href="{{route('Suppliers.create')}}" class>Tạo</a>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>address</th>
                <th>phone<th>
                    <th><th>
            </tr>
            </thead>
            <tbody>
            @if (isset($Suppliers) && count($Suppliers) > 0)
    @foreach ($Suppliers as $Supplier)
    <tr>
                        <td>{{$Supplier->supplier_id}}</td>
                        <td>{{$Supplier->name}}</td>
                        <td>{{$Supplier->address}}</td>
                        <td>{{$Supplier->phone_number}}</td>
                        <td><a href="{{ route('Suppliers.show', $Supplier->supplier_id) }}" class="btn btn-warning">Xem</a>
                       </td>
    </tr>
    @endforeach
    {{ $Suppliers->links() }}
    @else
    <p>Không có Supplier nào.</p>
    @endif
            </tbody>
        </table>
        @include('admin.components.footer')
    </section>
@endsection
