@if ($paginator->hasPages())
    <nav aria-label="التنقل بين الصفحات">
        <ul class="pagination pagination-sm justify-content-center mb-0" style="gap: 0.25rem;">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link"><i class="bi bi-chevron-right"></i> السابق</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="bi bi-chevron-right"></i>
                        السابق</a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">التالي <i class="bi bi-chevron-left"></i></a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">التالي <i class="bi bi-chevron-left"></i></span>
                </li>
            @endif
        </ul>
    </nav>

    <div class="text-center mt-2">
        <small class="text-muted">
            عرض {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} من {{ $paginator->total() }} نتيجة
        </small>
    </div>
@endif