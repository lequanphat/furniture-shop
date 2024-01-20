<div class="w-[16%] h-[100%] bg-primary p-4 text-white">
<div class="flex flex-col justify-between h-[100%]">
    <div class="flex flex-col ">
        <h1 class="text-white font-semibold text-xl mb-5 ">Admin Site</h1>
        <ul>
            <li >
                <a class="flex items-center p-2 my-2 hover:bg-[rgba(255,255,255,0.2)] transition-all rounded {{ request()->is('admin') ? 'bg-[rgba(255,255,255,0.2)]' : '' }}"  href="/admin">
                    <div class="w-[14%]"><i class="fas fa-home "></i></div>
                    <span>Dashboard</span>
                </a>
            </li>
            <li >
                <a class="flex items-center p-2 my-2 hover:bg-[rgba(255,255,255,0.2)] transition-all roundedhover:bg-[rgba(255,255,255,0.2)] rounded {{ request()->is('admin/users') ? 'bg-[rgba(255,255,255,0.2)]' : '' }}" href="/admin/users">
                    <div class="w-[14%]"><i class="fas fa-user "></i></div><span>Users</span>
                </a>
            </li>
            <li >
                <a class="flex items-center p-2 my-2 hover:bg-[rgba(255,255,255,0.2)] transition-all roundedhover:bg-[rgba(255,255,255,0.2)] rounded {{ request()->is('admin/groups') ? 'bg-[rgba(255,255,255,0.2)]' : '' }}" href="/admin/groups">
                    <div class="w-[14%]"><i class="fas fa-users "></i></div>
                    <span>Classroom</span>
                </a>
            </li>
            <li >
                <a class="flex items-center p-2 my-2 hover:bg-[rgba(255,255,255,0.2)] transition-all rounded {{ request()->is('admin/products') ? 'bg-[rgba(255,255,255,0.2)]' : '' }}" href="/admin/products">
                    <div class="w-[14%]"><i class="fas fa-server"></i></div>
                    <span>Tests</span></a></li>
            <li >
                <a class="flex items-center p-2 my-2 hover:bg-[rgba(255,255,255,0.2)] transition-all rounded {{ request()->is('admin/secure') ? 'bg-[rgba(255,255,255,0.2)]' : '' }}" href="/admin/secure">
                    <div class="w-[14%]"><i class="fas fa-unlock-alt"></i></div>
                    <span>Secure</span></a></li>
        </ul>
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <img src="{{ asset('uploads/images/avatar.jpg') }}" alt="avatar" class="rounded-[50%] w-[36px] h-[36px] mr-2">
            <h1 class="text-white text-md ">{{ session('user')->displayName }}</h1>
        </div>
        <form action="/logout">
            <button type="submit" class="text-white font-semibold text-xl "><i class="fas fa-power-off "></i></button>
        </form>
    </div>
</div>
</div>