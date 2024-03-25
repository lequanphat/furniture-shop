@extends('layouts.admin')
@section('content')
    <section id="main-content">
        <form action="{{route('brands.search')}}" method="GET">
        <input type="text" name="keyword" id="keyword" placeholder="Tìm kiếm Brand">
        <button type="submit">Tìm kiếm</button>
        </form>
        <a class="btn btn-primary" href="{{route('brands.create')}}" class>Tạo</a>
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
            @if (isset($brands) && count($brands) > 0)
    @foreach ($brands as $brand)
    <tr>
                        <td>{{$brand->brand_id}}</td>
                        <td>{{$brand->name}}</td>
                        <td>{{$brand->index}}</td>
                   
                        <td><a href="{{ route('brands.show', $brand->brand_id) }}" class="btn btn-warning">Xem</a>
    </tr>
    @endforeach
    @else
    <p>Không có brand nào.</p>
    @endif
            </tbody>
        </table>
        {{ $brands->links() }}
</select>
        @include('admin.components.footer')
    </section>
@endsection