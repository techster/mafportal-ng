<section class="ClubsPage">
    <div class="container">

        <div class="descWr">
            <div class="warn text-red">{!! trans('clubs.sub_title') !!}</div>
            <p>{!! trans('clubs.description') !!}</p>
        </div>

        <div class="line"></div>

        @if($countries)
            <div class="clubList">
                <ul>
                    @foreach($countries as $country_key => $country)
                        <li class="item">
                            @if($country->title)
                                <div class="country">
                                    {{$country->title}}
                                </div>
                            @endif

                            @if($country->image && is_file(public_path(ltrim(parse_url($country->image, PHP_URL_PATH) ?: $country->image, '/'))))
                                <div class="pic" style="background-image: url({{ $country->image }});">
                                    <img src="{{URL::to('/build/img/1_1.gif')}}" alt="">
                                </div>
                            @else
                                <div class="pic" style="background-image: url({{URL::to('/build/img/not_img.jpg')}});">
                                    <img src="{{URL::to('/build/img/1_1.gif')}}" alt="">
                                </div>
                            @endif

                            @if($clubs)
                                <ul class="cityList">
                                    @foreach($clubs as $club_key => $club)
                                        @if($club->country_id == $country->id)
                                            <li>
                                                <a href="{{ route('club_about', [$club->slug]) }}">
                                                    {{$club->title}}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif

                            @if($country->description)
                                <div class="desc">
                                    {!! $country->description !!}
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</section>