{{--<?php--}}
{{--$show = $show ? $show : true;--}}
{{--?>--}}

{{--@if ($show)--}}
    {{--<div class="langBox" ng-controller="landCtrl" ng-cloak>--}}
        {{--@if(App::getLocale() == 'en')--}}
            {{--<ul ng-class="{'toggled': Open}" class="langList" ng-click="Open = !Open">--}}
                {{--<li id="select" class="curent">Eng</li>--}}
            {{--</ul>--}}
            {{--<ul ng-show="Open" class="other">--}}
                {{--<li><a href="/ru/{{ Request::path() }}">РУС</a></li>--}}
            {{--</ul>--}}
        {{--@else--}}
            {{--<ul ng-class="{'toggled': Open}" class="langList" ng-click="Open = !Open">--}}
                {{--<li id="select" class="curent">РУС</li>--}}
            {{--</ul>--}}
            {{--<ul ng-show="Open" class="other">--}}
                {{--<li><a href="{{ str_replace("/ru/", "/", "/" . Request::path() . "/") }}">Eng</a></li>--}}
            {{--</ul>--}}
        {{--@endif--}}
    {{--</div>--}}
{{--@endif--}}
