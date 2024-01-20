<div class="w-[16%] h-[100%] bg-primary p-4">
<div class="flex flex-col justify-between h-[100%]">
    <h1 class="text-white font-semibold text-xl ">Admin Site</h1>
    <div class="flex items-center">
        <img src="{{ asset('uploads/images/avatar.jpg') }}" alt="avatar" class="rounded-[50%] w-[36px] h-[36px]">
        <p class="text-white text-sm ">{{ session('user')->displayName }}</p>
        <form action="/logout">
            <button type="submit" class="text-white font-semibold text-xl ">Out</button>
        </form>
    </div>
</div>
</div>