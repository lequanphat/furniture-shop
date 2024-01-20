@extends('layouts.admin')
@section('content')
<div class="flex item-center justify-center">
    <div>
        <div class="border-[1px] border-black p-4 mb-5"> <h1 class='text-center font-semibold'>Create Product</h1>
            <form action="/products/create-product" method="post">
                @csrf
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="border-[1px] border-black p-1 block rounded w-[100%] mb-4"> 
                <label for="email">Price:</label>
                <input type="text" name="price" id="price" class="border-[1px] border-black p-1  block rounded w-[100%] mb-4">
                <button type="submit" class="border-[2px] border-white py-1 px-3 rounded bg-[#0984e3] text-white">Submit</button>
            </form></div>
        <table>
            <tr class="border-[1px] border-black bg-[#74b9ff]">
                <td class="border-[1px] border-black p-2">ID</td>
                <td class="border-[1px] border-black p-2">Name</td>
                <td class="border-[1px] border-black p-2">Price</td>
                <td class="border-[1px] border-black p-2">CreatedAt</td>
                <td class="border-[1px] border-black p-2">...</td>
            </tr>
            @foreach ($products as $item)
                <tr class="border-[1px] border-blackbg-[#dfe6e9]">
                    <td class="border-[1px] border-black p-2" class="border-[1px] border-black p-2">{{ $item['id'] }}</td>
                    <td class="border-[1px] border-black p-2">{{ $item['name'] }}</td>
                    <td class="border-[1px] border-black p-2">{{ $item['price'] }}</td>
                    <td class="border-[1px] border-black p-2">{{ $item['created_at'] }}</td>
                    <td class="border-[1px] border-black p-2">
                        <form action={{ "/products/delete/".$item['id'] }} method="DELETE" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')" class="text-red-500">Delete</button>
                            </form>
                    </td>
                </tr>
            @endforeach
        </table>
        </div>
    </div>
@endsection