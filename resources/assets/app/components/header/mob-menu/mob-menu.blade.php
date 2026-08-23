<?php
$active = isset($active) ? $active : 0;
?>
<section class="MobileBox" ng-controller="MobMenuCtrl">
    <!--[ BG_FON ]-->
    <div id="eff_bl"></div>
    <div class="mob_menu">
        <!--[ BTN ]-->
        <a id="menu-toggle" href="#" class="button menu-icon-wrp">
            <span class="sr"></span>
            <span class="menu-bar bar1"></span>
            <span class="menu-bar bar2"></span>
            <span class="menu-bar bar3"></span>
        </a>
        <!--[ MENU ]-->
        <nav id="nav-wrp" class="vhm animated nav-style open ns1_in">
            <!--[ LOGO ]-->
            <div class="logoWr">
                <a href="/">
                    <img class="logo_mob" src="{{URL::to('/build/img/logo.svg')}}" alt="Maf club">
                    <div class="logoMane">Maf club</div>
                </a>
            </div>
            <!--[ LIST ]-->
            <ul id="navigation">
                @foreach($menu as $key => $item)
                    @if($item->parent_id == null)
                        <li>
                            @if($item->link == null)
                                @if(\App\Models\MenuItem::where('parent_id', $item->id)->count() > 0)
                                    <a id='{{$item->id}}' name="{{$item->name}}" data-ng-click="ShowId_unlink($event)"
                                       class="dropbtn1"
                                       href=""
                                    >
                                        {{$item->name}} &#9660
                                    </a>
                                @else
                                    <a class="dropbtn1"
                                       href=""
                                    >
                                        {{$item->name}}
                                    </a>
                                @endif

                            @elseif(\App\Models\MenuItem::where('parent_id', $item->id)->count() > 0)
                                <a class="{{(Request::segment(2) == $item->link || Request::segment(1)== $item->link ?'act':'')}}"
                                   href="
                                @if ($item->type == "external_link")
                                   {{ $item->link }}
                                   @endif
                                   @if ($item->type !== "external_link")
                                   {{ '/'.App::getLocale() }}/{{ $item->link }}/
                               @endif
                                           "
                                >
                                    {{$item->name}}
                                </a>
                                <div id="{{$item->id}}" data-ng-click="ShowId($event)"
                                     style=" font-size:20px;cursor:pointer; color: white; display: inline-block;">&#9660
                                </div>
                            @else
                                <a class="{{(Request::segment(2) == $item->link || Request::segment(1)== $item->link ?'act':'')}}"
                                   href="
                                @if ($item->type == "external_link")
                                   {{ $item->link }}
                                   @endif
                                   @if ($item->type !== "external_link")
                                   {{ '/'.App::getLocale() }}/{{ $item->link }}/
                               @endif">
                                    {{$item->name}}
                                </a>
                            @endif
                            @if(\App\Models\MenuItem::where('parent_id', $item->id)->count() > 0)
                                <ul id="drop-{{$item->id}}" class="hidden">
                                    @foreach(\App\Models\MenuItem::where('parent_id', $item->id)->get() as $keys => $items)
                                        <li style="padding-left: 15px;"><a href="
                                            @if ($items->type == "external_link")
                                            {{ $items->link }}
                                            @endif
                                            @if ($items->type !== "external_link")
                                            {{ '/'.App::getLocale() }}/{{ $items->link }}/
                                            @endif
                                                    "
                                            >{{$items->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
                <li class="dropdown1">
                    @php
                        $locale = Config::get('app.locale');

                        $global_menu_items = \App\Models\GlobalRating::orderBy('created_at', 'dsec')->get();
                    @endphp
                    <a class="dropbtn1" href="">
                        {{ in_array($locale, ['en', 'EN']) ? 'Global Rating' : 'Глобальный рейтинг' }} &#9660;
                    </a>
                    <div class="dropdown-content1">
                        <div>
                            @foreach($global_menu_items as $row)
                                <a href="{{ route('club_global_rating', $row->id) }}">
                                    {{ in_array($locale, ['en', 'EN']) ? $row->rating_title : $row->rating_title_ru }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</section>
