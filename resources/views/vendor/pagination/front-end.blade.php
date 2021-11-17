@if ($paginator->hasPages())
    <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li><a href="javascript:void(0)"><i class="flaticon-left-arrow"></i></a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}"><i class="flaticon-left-arrow"></i></a></li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <li>{{ $element }}</li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a href="{{$url}}" class="active">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}"> <i class="flaticon-right-arrow"></i></a></li>
        @else
            <li><a href="javascript:void(0)"><i class="flaticon-right-arrow"></i></a></li>
        @endif
    </ul>
@endif

