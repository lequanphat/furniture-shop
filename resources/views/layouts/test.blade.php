<!DOCTYPE html>
<html lang="en">
@include('components.head')

<body>
    <header>
        <div class="flex h-[80px] w-[100vw] items-center justify-center bg-red-400">Header</div>

        <nav class="w-[100vw] bg-green-400 p-2">
            <button class="block w-[60px] rounded bg-gray-600 text-white lg:hidden" onclick="handleToggleMenu()">
                Menu</button>
            <ul id="menu">
                <li
                    class="m-1 block cursor-pointer rounded bg-black px-4 py-1 text-white transition-all hover:bg-white hover:text-black lg:inline-block">
                    Li 1</li>
                <li
                    class="m-1 block cursor-pointer rounded bg-black px-4 py-1 text-white transition-all hover:bg-white hover:text-black lg:inline-block">
                    Li 2</li>
                <li
                    class="m-1 block cursor-pointer rounded bg-black px-4 py-1 text-white transition-all hover:bg-white hover:text-black lg:inline-block">
                    Li 3</li>
                <li
                    class="m-1 block cursor-pointer rounded bg-black px-4 py-1 text-white transition-all hover:bg-white hover:text-black lg:inline-block">
                    Li 4</li>
                <li
                    class="m-1 block cursor-pointer rounded bg-black px-4 py-1 text-white transition-all hover:bg-white hover:text-black lg:inline-block">
                    Li 5</li>
            </ul>
        </nav>
    </header>
    <div class="flex">
        <div class="w-[20%] bg-yellow-300 p-4">
            <ul>
                @php
                    $items = [1, 2, 3, 4, 5, 6, 7, 8];
                @endphp
                @foreach ($items as $item)
                    <li class="my-2 cursor-pointer rounded bg-red-400 p-2 hover:bg-green-300">Sidebar 1</li>
                @endforeach


            </ul>
        </div>
        <div class="flex flex-1 flex-wrap justify-evenly bg-pink-300 pt-5">
            @php
                $items = [1, 2, 3, 4, 5, 6, 7, 8];
            @endphp
            @foreach ($items as $item)
                <div class="mb-5 h-[200px] w-[22%] rounded bg-green-300 hover:bg-yellow-300"></div>
            @endforeach

        </div>
        <div class="hidden w-[20%] items-center justify-center bg-blue-400 lg:flex">right</div>
    </div>
    <footer class="h-[40px] bg-gray-500">Footer</footer>
</body>

<script>
    const handleToggleMenu = () => {

        const isHidden = document.querySelector('#menu').classList.contains("hidden");
        if (isHidden) {
            document.querySelector('#menu').classList.remove('hidden');
        } else {
            document.querySelector('#menu').classList.add('hidden');
        }

    }
</script>

</html>
