<ul id="pagination" class="pagination my-2 ms-auto">
    <li>
        <a class="pagination-item @if ($paginator->onFirstPage()) disabled @endif" href="#shop"
            data-page="{{ $paginator->currentPage() - 1 }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M15 6l-6 6l6 6" />
            </svg>
        </a>
    </li>

    {{-- Display first page --}}
    @if ($paginator->currentPage() > 3)
        <li>
            <a class="pagination-item" data-page="{{ $paginator->url(1) }}" href="#shop">1</a>
        </li>
    @endif

    @if ($paginator->currentPage() > 4)
        <li>
            <a class="pagination-item disabled" href="#shop">...</a>
        </li>
    @endif

    @foreach ($elements as $element)
        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <a class="pagination-item active" href="#shop">{{ $page }}</a>
                        </li>
                    @else
                        <li>
                            <a class="pagination-item " href="#shop"
                                data-page="{{ $page }}">{{ $page }}</a>
                        </li>
                    @endif
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->currentPage() < $paginator->lastPage() - 3)
        <li>
            <a class="pagination-item disabled" href="#shop">...</a>
        </li>
    @endif

    @if ($paginator->currentPage() < $paginator->lastPage() - 2)
        {{-- Last Page Link --}}
        <li>
            <a class="pagination-item" href="#shop"
                data-page="{{ $paginator->lastPage() }}">{{ $paginator->lastPage() }}</a>
        </li>
    @endif

    <li>
        <a class="pagination-item @if ($paginator->currentPage() == $paginator->lastPage()) disabled @endif" href="#shop"
            data-page="{{ $paginator->currentPage() + 1 }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M9 6l6 6l-6 6" />
            </svg>
        </a>
    </li>
</ul>
