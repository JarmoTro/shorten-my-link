@if ($paginator->hasPages())

    <nav class="urls-pagination">

        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}">
                Previous
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">
                Next
            </a>
        @endif
        
    </nav>

@endif
