    <ul class="pagination my-2 ms-auto">
        <li class="page-item @if ($paginator->onFirstPage()) disabled @endif">
            <a class="page-link" data-page="{{ $paginator->currentPage() - 1 }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M15 6l-6 6l6 6" />
                </svg>
                prev
            </a>
        </li>

        {{-- Display first page --}}
        @if ($paginator->currentPage() > 3)
            <li class="page-item">
                <a class="page-link" rel="first" data-page="{{ $paginator->url(1) }}">1</a>
            </li>
        @endif

        @if ($paginator->currentPage() > 4)
            <li class="page-item disabled mx-1">
                <a class="page-link">...</a>
            </li>
        @endif

        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled mx-1">
                    <a class="page-link">{{ $element }}</a>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active mx-1">
                                <a class="page-link">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item mx-1">
                                <a class="page-link" data-page="{{ $page }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item disabled mx-1">
                <a class="page-link">...</a>
            </li>
        @endif

        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
            {{-- Last Page Link --}}
            <li class="page-item">
                <a class="page-link" data-page="{{ $paginator->lastPage() }}"
                    rel="last">{{ $paginator->lastPage() }}</a>
            </li>
        @endif

        <li class="page-item @if (!$paginator->hasMorePages()) disabled @endif">
            <a class="page-link" data-page="{{ $paginator->currentPage() + 1 }}">
                next
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 6l6 6l-6 6" />
                </svg>
            </a>
        </li>

    </ul>
