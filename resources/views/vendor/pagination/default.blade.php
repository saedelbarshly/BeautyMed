@if ($paginator->hasPages())
    <div class="d-flex justify-content-center  mt-2">
        <nav aria-label="Page navigation">
            <ul class="pagination mb-2">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item prev-item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <a class="page-link"></a>
                    </li>
                @else
                    <li class="page-item prev-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item active" aria-disabled="true"><span>{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link">{{ $page }}</a>
                                </li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item next-item">
                        <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next" aria-label="@lang('pagination.next')"></a>
                    </li>
                @else
                    <li class="page-item next-item" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <a class="page-link"></a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
