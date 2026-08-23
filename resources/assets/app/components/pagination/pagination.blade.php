<section>
    <div class="container">
        <div class="MyPagination">
            @if (isset($paginator) && $paginator->hasPages())
                <ul>
                    @foreach ($elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="act"><a href="{{ $url }}">{{ $page }}</a></li>
                                @else
                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</section>
