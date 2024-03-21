@if ($paginator->hasPages())
    <ul class="pagination my-2 ms-auto">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#">

                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 6l-6 6l6 6" />
                    </svg>
                    prev
                </a>
            </li>
        @else
            <li class="page-item ">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 6l-6 6l6 6" />
                    </svg>
                    prev
                </a>
            </li>
        @endif

        {{-- Display first page --}}
        @if ($paginator->currentPage() > 3)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}" rel="first">1</a>
            </li>
        @endif

        @if ($paginator->currentPage() > 4)
            <li class="page-item disabled mx-1">
                <a class="page-link" href="#">...</a>
            </li>
        @endif

        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled mx-1">
                    <a class="page-link" href="#">{{ $element }}</a>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active mx-1">
                                <a class="page-link" href="#">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item mx-1">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item disabled mx-1">
                <a class="page-link" href="#">...</a>
            </li>
        @endif

        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
            {{-- Last Page Link --}}
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}"
                    rel="last">{{ $paginator->lastPage() }}</a>
            </li>
        @endif

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    next
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 6l6 6l-6 6" />
                    </svg>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" href="#">
                    next
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 6l6 6l-6 6" />
                    </svg>
                </a>
            </li>
        @endif
    </ul>
@endif
