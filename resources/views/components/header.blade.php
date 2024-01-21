<div class="w-[100vw] bg-[#ecf0f1]">
    <div class="mx-auto flex w-[80%] items-center justify-between py-2">
        <h1 class="text-red text-lg font-semibold"><a href="/">LOGO</a></h1>
        <div class="flex items-center">
            <ul class="mr-4 flex items-center">
                <li class="px-2 font-[600] text-[#71869d] hover:text-primary "><a href="/tests">Đề thi online</a></li>
                <li class="px-2 font-[600] text-[#71869d] hover:text-primary "><a href="/test-result">Kết quả thi</a></li>
                <li class="px-2 font-[600] text-[#71869d] hover:text-primary "><a href="/classroom">Lớp học của tôi</a></li>
            </ul>
            <div class="flex cursor-pointer items-center">
                <img src="{{ asset('uploads/images/avatar.jpg') }}" alt="avatar"
                    class="mr-2 h-[32px] w-[32px] rounded-[50%]">
            </div>
            <form action="/logout">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</div>
