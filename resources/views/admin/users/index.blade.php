@extends('layouts.admin')
@section('content')
<div class="flex flex-1 item-center justify-center">
    <div>
        <div class="border-[1px] border-black p-4 mb-5"> <h1 class='text-center font-semibold'>Create User</h1>
            <form action="/admin/users/create-user" method="post">
                @csrf
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="{{ old('email') }}" class="border-[1px] border-black p-1 block rounded w-[100%] mb-4"> 
                <label for="password">Password:</label>
                <input type="text" name="password" id="password" value="{{ old('password') }}" class="border-[1px] border-black p-1  block rounded w-[100%] mb-4">
                <label for="displayName">Display name:</label>
                <input type="text" name="displayName" id="displayName" value="{{ old('displayName') }}" class="border-[1px] border-black p-1  block rounded w-[100%] mb-2">
                @if ($errors->any())
                    <p class="text-red-400">*{{ $errors->all()[0] }}</p>
                @endif
               
                <button type="submit" class="border-[2px] border-white py-1 px-3 rounded bg-[#0984e3] text-white mt-2">Submit</button>
            </form></div>
        <table>
            <tr class="border-[1px] border-black bg-[#74b9ff]">
                <td class="border-[1px] border-black p-2">ID</td>
                <td class="border-[1px] border-black p-2">Email</td>
                <td class="border-[1px] border-black p-2">Display Name</td>
                <td class="border-[1px] border-black p-2">CreatedAt</td>
                <td class="border-[1px] border-black p-2">Role</td>
                <td class="border-[1px] border-black p-2">...</td>
            </tr>
            @foreach ($users as $item)
                <tr class="border-[1px] border-blackbg-[#dfe6e9]">
                    <td class="border-[1px] border-black p-2" class="border-[1px] border-black p-2">{{ $item['id'] }}</td>
                    <td class="border-[1px] border-black p-2">{{ $item['email'] }}</td>
                    <td class="border-[1px] border-black p-2">{{ $item['displayName'] }}</td>
                    <td class="border-[1px] border-black p-2">{{ $item['created_at'] }}</td>
                    <td class="border-[1px] border-black p-2">{{ $item->getRoleNames() }}</td>
                    <td class="border-[1px] border-black p-2">
                        <form action={{ "/admin/users/delete/".$item['id'] }} method="DELETE" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')" class="text-red-500">Delete</button>
                            </form>
                    </td>
                </tr>
            @endforeach
        </table>
        </div>
    </div>
    
@endsection