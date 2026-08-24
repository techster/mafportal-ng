<section class="TournamentsPage" ng-controller="tournaments_archiveCtrl">
    <?php
        $years = [];
        foreach ($tournaments as $tournament) {
            $years[] = $tournament->created_at->format('Y');
        }
        $years = array_unique($years);
        rsort($years);
    ?>
    <div class="container">
        <!--[ TITLE ]-->
        <div class="default_title title">
            <div class="left_line lineDef"></div>
            <div class="title_name">{{trans('tournaments.title_long')}}</div>
            <div class="right_line lineDef"></div>
        </div>
        <div class="TournamentFilters">
            <label for="tournament-year">{{trans('tournaments.year')}}</label>
            <select id="tournament-year" ng-model="selectedYear">
                <option value="all">{{trans('tournaments.all_years')}}</option>
                @foreach($years as $year)
                    <option value="{{$year}}">{{$year}}</option>
                @endforeach
            </select>
        </div>
        <!--[ CONTENT ]-->
        <div class="contWr">
            <ul class="TournamentList">
                @if($tournaments)
                    @foreach($tournaments as $key => $value)
                        <li class="item" ng-if="selectedYear == 'all' || selectedYear == '{{$value->created_at->format('Y')}}'">
                            <div class="pic" style="background-image: url({{ $value->preview ? $value->preview : '/build/img/not_img.jpg' }});">
                                <a href="{{ route('single_tournaments', [$value->slug]) }}">
                                    <img src="{{URL::to('/build/img/36_20.gif')}}" alt="pic">
                                </a>
                            </div>
                            <div class="info">
                                <a href="{{ route('single_tournaments', [$value->slug]) }}#about">
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
                    @endforeach
                @endif
            </ul>

        </div>
    </div>
</section>

