<?php
$news = isset($news) ? $news : [];
$class = isset($class) ? $class : [''];
?>

@if($news)
    <section class="NewsList @foreach($class as $clasName) {{ $clasName }} @endforeach">
        <div class="container">

            @foreach($news as $key => $value)
                <div class="News_item">
                    <a href="{{ route('single_news', [$value->slug]) }}">
                        @if($value->title)
                            <h2 class="title">
                                {{$value->title}}
                            </h2>
                        @endif

                        <div class="content">
                            @if($value->created_at)
                                <div class="dateWr">
                                    <div class="date">{{$value->created_at->format('d M Y')}}</div>
                                </div>
                            @endif

                            @if($value->description)
                                <div class="desc">
                                    {{$value->description}}
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </section>
@endif