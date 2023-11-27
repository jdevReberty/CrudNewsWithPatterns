@if (isset($paginator))
    @php
        $queryParams = (isset($appends) && gettype($appends) == 'array') ? '&' . http_build_query($appends) : '';
    @endphp

    <nav role="navigation" aria-label="Pagination Navigation" class="d-flex flex justify-content-end">
        {{-- Previous Page Link --}}
        @if ($paginator->isFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="?page={{$paginator->getNumberPreviousPage()}}{{$queryParams}}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                {!! __('pagination.previous') !!}
            </a>
        @endif
        {{-- Number Page Navigator --}}
        @php
            // dd($paginator->total());
        @endphp
        @if ($paginator->total() > 0)
            <div class="d-flex">
                <a @if(!$paginator->isFirstPage()) href="?page={{ 1 }}{{$queryParams}}" @endif rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    <i class="tim-icons icon-double-left"></i>
                </a>
                @for ($i = (($paginator->currentPage() > 1) ? $paginator->currentPage() - 1 : $paginator->currentPage()); ($i <= $paginator->currentPage() + 1); $i++)
                    <a @if($i != $paginator->currentPage()) href="?page={{ $i }}{{$queryParams}}" @endif  rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        {{ $i }}
                    </a>
                    @if ($i == $paginator->getLastPage())
                        @break
                    @endif
                @endfor
                <a @if(!$paginator->isLastPage()) href="?page={{ $paginator->getLastPage() }}{{$queryParams}}" @endif rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    <i class="tim-icons icon-double-right"></i>
                </a>
            </div>
        @endif

        {{-- Next Page Link --}}
        @if (!$paginator->isLastPage())
            <a href="?page={{ $paginator->getNumberNextPage() }}{{$queryParams}}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
