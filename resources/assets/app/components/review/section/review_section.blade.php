@if($testimonials)
    <section class="ReviewBox"  style="background-image: url({{URL::to('/build/img/testimonials_pic.jpg')}});">
        <div class="container">
            <div class="reviewWr" ng-controller="review_sectionCtrl" ng-cloak>
                <!--[ TITLE ]-->
                <div class="title">
                    <div class="left_line lineDef"></div>
                    <div class="title_name">{{ trans('main.testimonials') }}</div>
                    <div class="right_line lineDef"></div>
                </div>
                @if(App::getLocale() == 'ru')
                    <style>
                        section.ReviewBox .glyphicon-chevron-right:before{
                            content: 'Следующий отзыв';
                            font-size: 20px;
                            color: #ffffff;
                        }
                        section.ReviewBox .glyphicon-chevron-left:before{
                            content: 'Предыдущий отзыв';
                            font-size: 20px;
                            color: #ffffff;
                        }
                    </style>
                @endif

                <div class="revieList" uib-carousel active="active" interval="myInterval" no-wrap="noWrapSlides">
                    @foreach($testimonials as $key => $testimonial)
                        <div uib-slide index="{{$key}}">
                            <div class="itemRevie" ng-class="'cap'+{{$key}}">
                                <div class="personWr">
                                    <div class="person" style="background-image: url({{ $testimonial->image }});"></div>
                                </div>
                                <div class="content">
                                    <h2 class="title_item">{{$testimonial->name}}</h2>
                                    <div class="textWr">
                                        <div class="line"></div>
                                        <div class="review">
                                            <p>{{$testimonial->text}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif