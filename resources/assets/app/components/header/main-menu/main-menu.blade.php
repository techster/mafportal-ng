<?php
$active = isset($active) ? $active : 0;
?>
<ul>
    @foreach($menu as $key => $item)
        @if($item->parent_id == null)
            <li class="dropdown1">
                @if($item->link == null)
                    @if(\App\Models\MenuItem::where('parent_id', $item->id)->count() > 0)
                    <a class="dropbtn1"
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

                @elseif (\App\Models\MenuItem::where('parent_id', $item->id)->count() > 0)
                    <a class="dropbtn1 {{(Request::segment(2) == $item->link || Request::segment(1)== $item->link ?'act':'')}}"
                       href="
                        @if ($item->type == "external_link")
                       {{ $item->link }}
                       @endif
                       @if ($item->type !== "external_link")
                       {{ '/'.App::getLocale() }}/{{ $item->link }}/
                       @endif
                               "
                    >
                        {{$item->name}} &#9660
                    </a>
                @else
                    <a class="dropbtn1 {{(Request::segment(2) == $item->link || Request::segment(1)== $item->link ?'act':'')}}"
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
                @endif



                @if(\App\Models\MenuItem::where('parent_id', $item->id)->count() > 0)

                    <div class="dropdown-content1">
                    @foreach(\App\Models\MenuItem::where('parent_id', $item->id)->get() as $keys => $items)

                            <div>
                                <a
                                    href="
                                        @if ($items->type == "external_link")
                                    {{ $items->link }}
                                    @endif
                                    @if ($items->type !== "external_link")
                                    {{ '/'.App::getLocale() }}/{{ $items->link }}/
                                    @endif
                                    "
                                    >{{$items->name}}
                            </a></div>


                    @endforeach
                    </div>
                @endif


            </li>
        @endif

    @endforeach
    <li class="dropdown1">
        @php
            $locale = Config::get('app.locale');
            
            $global_menu_items = \App\Models\GlobalRating::orderBy('created_at', 'dsec')->get();
        @endphp
        <a class="dropbtn1" href="" >
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