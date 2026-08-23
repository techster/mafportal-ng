<?php
$class = isset($class) ? $class : ['m-t-40'];
$PhotoGalleries = isset($PhotoGalleries) ? $PhotoGalleries : "";
$VideoGalleries = isset($VideoGalleries) ? $VideoGalleries : "";
?>

<section class="Gallery @foreach($class as $key) {{$key}} @endforeach" ng-controller="gallery_archiveCtrl" ng-cloak>
    <div class="container">
        <!--[ BTN ]-->
        <div class="btnWr">
            <a ng-class="{'act': visible}" href="" ng-click="photo()">{{trans('clubs.photo')}}</a>
            <a ng-class="{'act': !visible}" href="" ng-click="video()">{{trans('clubs.video')}}</a>
        </div>
        <!--[ LINE ]-->
        <div class="lineWr">
            <div class="line">
                <span ng-show="visible">{{trans('clubs.photo_albums')}}</span>
                <span ng-hide="visible">{{trans('clubs.video_albums')}}</span>
            </div>
        </div>
        <!--[ CONTENT ]-->
        <div class="GalleryList">
            <!--[ PHOTO ]-->
            <div class="mediaList" ng-show="visible">
                <div class="row">
                    @if($PhotoGalleries && count($PhotoGalleries))
                        @foreach($PhotoGalleries as $key => $gallery)
                            <div class="item col-xs-12 col-md-4 col-sm-6">
                                <a href="{{ route('single_photo', [$gallery->slug]) }}">
                                    <div class="pic" style="background-image: url({{ $gallery->preview }});">
                                        <img src="{{URL::to('/build/img/51_34.gif')}}" alt="pic">
                                        <div class="gi-overlay">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    <div class="item_title">
                                        {{$gallery->title}}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <h4 class="text-red no_cont">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                <span>{{trans('clubs.no_photo')}}</span>
                            </h4>
                        </div>
                    @endif
                </div>
            </div>
            <!--[ VIDEO ]-->
            <div class="mediaList" ng-hide="visible">
                <div id="video" class="row">
                    @if ($VideoGalleries && count($VideoGalleries))
                        @foreach($VideoGalleries as $key => $gallery)
                            <a href="https://www.youtube.com/watch?v={{$gallery->id_youtube}}"
                               data-poster="//img.youtube.com/vi/{{$gallery->id_youtube}}/maxresdefault.jpg"
                               class="col-xs-12 col-md-4 col-sm-6 item" title="{{$gallery->title}}">
                                <div class="pic"
                                    @if($gallery->preview)
                                        style="background-image: url({{ $gallery->preview }});">
                                    @else
                                        style="background-image: url(//img.youtube.com/vi/{{$gallery->id_youtube}}/mqdefault.jpg);">
                                    @endif
                                    <img src="{{URL::to('/build/img/51_34.gif')}}" alt="{{$gallery->title}}">
                                    <div class="gi-overlay">
                                        <i class="fa fa-youtube-play"></i>
                                    </div>
                                </div>
                                <div class="item_title">
                                    {{$gallery->title}}
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <h4 class="text-red no_cont">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                <span>{{trans('clubs.no_video')}}</span>
                            </h4>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>