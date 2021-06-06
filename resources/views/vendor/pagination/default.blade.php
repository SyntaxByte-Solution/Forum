@if ($paginator->hasPages())

    <div class="flex align-center">
        {{-- Previous Page Link --}}

        @php
            $current_page_number = $paginator->currentPage();
            $current_page_url = url()->full();
            $next_page_url = '';

            if(str_contains($current_page_url, 'page')) {
                if(request()->has('pagesize')) {
                    $ps = request()->input('pagesize');
                    $previous_page_url = $paginator->url($current_page_number-1) . '&pagesize=' . $ps;
                    $next_page_url = $paginator->url($current_page_number+1) . '&pagesize=' . $ps;
                } else {
                    $previous_page_url = $paginator->url($current_page_number-1);
                    $next_page_url = $paginator->url($current_page_number+1);
                }
            } else {
                $next_page_url = $paginator->url($current_page_number+1);
            }

        @endphp

        @if (!$paginator->onFirstPage())
            <a href="{{ $previous_page_url }}" class="pagination-item pag-active" rel="prev" aria-label="@lang('pagination.previous')">Prev</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="pagination-disabled pagination-item" aria-disabled="true">..</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @php
                        if(request()->has('pagesize')) {
                            $url = $url . '&pagesize=' . $ps;
                        }
                    @endphp
                    @if ($page == $paginator->currentPage())
                        <a href="{{ $url }}" class="pagination-item-selected pagination-item" aria-current="page">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}" class="pagination-item pag-active" >{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $next_page_url }}" class="pagination-item pag-active" aria-disabled="true" aria-label="@lang('pagination.next')">Next</a>
        @endif
    </div>
@endif

