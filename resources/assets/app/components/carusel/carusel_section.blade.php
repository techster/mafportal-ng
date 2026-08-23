<?php
    $btn_down     = isset ($btn_down)     ? $btn_down     : false;
    $btn_class    = isset ($btn_class)    ? $btn_class    : '';
    $slides       = isset ($slides)       ? $slides       : array();
    $title        = isset ($title)        ? $title        : '';
    $btn_text     = isset ($btn_text)     ? $btn_text     : '';
    $btn_link     = isset ($btn_link)     ? $btn_link     : '';
?>

@if(App::getLocale() == 'ru')
    <style>
        section.Carusel span.glyphicon.glyphicon-chevron-right:before{
            content: 'Вперед';
            right: -36px;
        }
        section.Carusel span.glyphicon.glyphicon-chevron-left:before{
            content: 'Назад';
            left: -24px;
        }
    </style>
@endif

<section class="Carusel" ng-controller="carusel_sectionCtrl" ng-cloak>
    <div uib-carousel active="active" interval="myInterval" no-wrap="noWrapSlides">
        @foreach ($slides as $key => $slide)
            <div uib-slide index="{{ $key }}">

                @if($slide->btn_text == null && $slide->btn_link !== null)
                <a href="{{ $slide->btn_link }} "><div class="item_pic" style="background-image: url({{ $slide->image }});"></div></a>
                    @else
                    <div class="item_pic" style="background-image: url({{ $slide->image }});"></div>
                @endif

                <div class="titleWr" ng-class="'cap{{ $key }}'">
                    @if($slide->btn_text == null && $slide->btn_link !== null)
                        @if($slide->title)
                            <a href="{{ $slide->btn_link }} "><h1 style="margin-top: 0px;margin-bottom: 0px;" class="title">
                                {{ $slide->title }}
                                </h1></a>
                        @endif

                        @if ($slide->description)
                                <a href="{{ $slide->btn_link }} "><div style="margin-bottom: 0;" class="desc">
                                {!! $slide->description !!}
                                    </div></a>
                        @endif
                    @else
                        @if($slide->title)
                            <h1 class="title">
                                {{ $slide->title }}
                            </h1>
                        @endif

                        @if ($slide->description)
                            <div class="desc">
                                {!! $slide->description !!}
                            </div>
                        @endif
                    @endif


                    @if($slide->btn_text !== null && $slide->btn_link !== null)
                        <div class="btnPost">
                            <a class="{{ $btn_class }}" href="{{ $slide->btn_link }}">{{ $slide->btn_text }}</a>
                        </div>
                    @endif

                </div>
            </div>
        @endforeach
    </div>
</section>

@if ($btn_down)
    <style>
        .carousel-control {top: 86%; width: 43%;}
        section.CaruselBox span.glyphicon.glyphicon-chevron-left,
        section.CaruselBox span.glyphicon.glyphicon-chevron-right {
            background-color: transparent;
        }
    </style>
@endif