@if ($paginator->hasPages())

    <!--
    <ul class="store-pagination">
        <li class="active">1</li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
    </ul>
---->

    <ul class="store-pagination">


            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <a class="prev_pagination"  rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fa fa-arrow-circle-left"></i>
                    </a>
                </li>
            @else
                <li>
                    <a class="prev_pagination" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fa fa-arrow-circle-left"></i>
                    </a>
                </li>
            @endif


            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <b>{{ $element }}</b>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active">
                               {{ $page }}
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="next_pagination" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </li>
            @else
                <li>
                    <a class="next_pagination" rel="next" aria-label="@lang('pagination.next')">
                        <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </li>
            @endif

    </ul>
@endif

