@if ($paginator->hasPages())
    <nav class="custom-pagination" role="navigation" aria-label="التنقل بين الصفحات">
        <style>
            .custom-pagination {
                display: flex;
                justify-content: center;
                margin: 40px 0 20px;
            }

            .custom-pagination .pagination-list {
                display: flex;
                gap: 6px;
                list-style: none;
                padding: 0;
                margin: 0;
                align-items: center;
                flex-wrap: wrap;
                justify-content: center;
            }

            .custom-pagination .page-item a,
            .custom-pagination .page-item span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 42px;
                height: 42px;
                padding: 0 14px;
                border-radius: 10px;
                font-family: 'Cairo', sans-serif;
                font-weight: 700;
                font-size: 0.9rem;
                text-decoration: none;
                transition: all 0.3s ease;
                border: 1.5px solid #e1e8f0;
                background: #fff;
                color: #1a1a1a;
            }

            .custom-pagination .page-item a:hover {
                border-color: #145b9b;
                color: #145b9b;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(20, 91, 155, 0.15);
            }

            .custom-pagination .page-item.active span {
                background: linear-gradient(135deg, #145b9b 0%, #0e4271 100%);
                color: #fff;
                border-color: #145b9b;
                box-shadow: 0 4px 15px rgba(20, 91, 155, 0.3);
            }

            .custom-pagination .page-item.disabled span {
                color: #ccc;
                background: #fdfdfd;
                border-color: #f0f0f0;
                cursor: not-allowed;
            }

            .custom-pagination .page-nav {
                font-size: 0.85rem;
                gap: 6px;
            }

            /* Mobile: hide page numbers, show only prev/next */
            @media (max-width: 576px) {
                .custom-pagination .page-number {
                    display: none;
                }

                .custom-pagination .page-dots {
                    display: none;
                }
            }
        </style>

        <ul class="pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-nav">« السابق</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-nav" rel="prev">« السابق</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled page-dots">
                        <span>{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active page-number">
                                <span>{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item page-number">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-nav" rel="next">التالي »</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-nav">التالي »</span>
                </li>
            @endif
        </ul>
    </nav>
@endif