@if ($paginator->hasPages())
    <div class="pagination">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination__el _disabled">←</li>
            @else
                <li class="pagination__el">
                    <a href="{{ $paginator->previousPageUrl() }}">
                        ←
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="pagination__el">
                        {{ $element }}
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination__el _active">
                                {{ $page }}
                            </li>
                        @else
                            <li class="pagination__el">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination__el">
                    <a class="next_pagination" href="{{ $paginator->nextPageUrl() }}">
                         →
                    </a>
                </li>
            @else
                <li class="pagination__el _disabled">→</li>
            @endif

    </div>
@endif

