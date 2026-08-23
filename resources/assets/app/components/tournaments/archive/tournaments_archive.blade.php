<section class="TournamentsPage" ng-controller="tournaments_archiveCtrl">
    <div class="container">
        <!--[ TITLE ]-->
        <div class="default_title title">
            <div class="left_line lineDef"></div>
            <div class="title_name">{{trans('tournaments.title_long')}}</div>
            <div class="right_line lineDef"></div>
        </div>
        <!--[ SWITCH ]-->
        <div class="switchWr">
            <a ng-class="{'act': visible }" href="" ng-click="com()">{{trans('tournaments.coming_soon')}}</a>
            <a ng-class="{'act': !visible}" href="" ng-click="vip()">{{trans('tournaments.past')}}</a>
        </div>
        <!--[ CONTENT ]-->
        <div class="contWr">
            <!--[ Coming Soon ]-->
            <ul class="TournamentList" ng-show="visible">
                @if($tournaments)
                    @foreach($tournaments as $key => $value)
                        @if($value->created_at->format('Y-m-d') >= date('Y-m-d'))
                            <li class="item">
                                <div class="pic" style="background-image: url({{ $value->preview ? $value->preview : '/build/img/not_img.jpg' }});">
                                    <a href="{{ route('single_tournaments', [$value->slug]) }}">
                                        <img src="{{URL::to('/build/img/36_20.gif')}}" alt="pic">
                                    </a>
                                </div>
                                <div class="info">
                                    <a href="{{ route('tournaments_about', [$value->slug]) }}">
                                        <div class="ListTitle">
                                            {{$value->title}}
                                        </div>
                                    </a>
                                    <div class="descWr">
                                        <div class="date">{{$value->created_at->format('d M Y')}}</div>
                                        @if($value->description)
                                            <div class="desc">
                                                {{$value->description}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
            <!--[ VIP ]-->
            <ul class="TournamentList" ng-hide="visible">
                @if($tournaments)
                    <?php 
                        $arr = [];
                        
                        foreach( $tournaments as $record ) {
                            $arr[] = $record;
                        }

                        $arr = array_reverse($arr);

                    ?>

                    @foreach($arr as $key => $value)
                        @if($value->created_at->format('Y-m-d') < date('Y-m-d'))
                            <li class="item">
                                <div class="pic" style="background-image: url({{ $value->preview ? $value->preview : '/build/img/not_img.jpg' }});">
                                    <a href="{{ route('single_tournaments', [$value->slug]) }}">
                                        <img src="{{URL::to('/build/img/36_20.gif')}}" alt="pic">
                                    </a>
                                </div>
                                <div class="info">
                                    <a href="{{ route('single_tournaments', [$value->slug]) }}">
                                        <div class="ListTitle">
                                            {{$value->title}}
                                        </div>
                                    </a>
                                    <div class="descWr">
                                        <div class="date">{{$value->created_at->format('d M Y')}}</div>
                                        @if($value->description)
                                            <div class="desc">
                                                {{$value->description}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>

        </div>
    </div>
</section>

