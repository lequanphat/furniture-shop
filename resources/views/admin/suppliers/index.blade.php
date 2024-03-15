@extends('layouts.admin')
@section('content')
    <section id="main-content">
        <form action="{{route('suppliers.search')}}" method="GET">
        <input type="text" name="keyword" id="keyword" placeholder="Tìm kiếm supplier" >
        <button type="submit">Tìm kiếm</button>
        </form>
        <a class="btn btn-primary" href="{{route('suppliers.create')}}" class>Tạo</a>
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
            @if (isset($suppliers) && count($suppliers) > 0)
    @foreach ($suppliers as $supplier)
    <tr>
                        <td>{{$supplier->supplier_id}}</td>
                        <td>{{$supplier->name}}</td>
                        <td>{{$supplier->address}}</td>
                        <td>{{$supplier->phone_number}}</td>
                        <td><a href="{{ route('suppliers.show', $supplier->supplier_id) }}" class="btn btn-warning">Xem</a>
                       </td>
    </tr>
    @endforeach
    @else
    <p>Không có supplier nào.</p>
    @endif
            </tbody>
        </table>
        {{ $suppliers->links() }}
        @include('admin.components.footer')
    </section>
@endsection
