@if(isset($about) && ($about->title || $about->title_rus))
    <section class="AboutBox">
        <div class="container">
            <div class="aboutWr">

                @if($about->title||$about->title_rus)
                    <div class="title">
                        <h1 class="title_name">
                            {!! App::getLocale()=='en'||!$about->title_rus?$about->title:$about->title_rus !!}
                        </h1>
                        <div class="right_line lineDef"></div>
                    </div>
                @endif

                <div class="contWr">
                    <div class="image" style="background-image: url({{URL::to('/build/img/about_pic.jpg')}});">
                        <img src="{{URL::to('/build/img/51_34.gif')}}" alt="pic">
                    </div>

                    @if($about->content||$about->content_rus)
                        <div class="desc">
                            {!! \App\Helpers::relativeLinks(App::getLocale()=='en'||!$about->content_rus?$about->content:$about->content_rus) !!}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>
@endif
