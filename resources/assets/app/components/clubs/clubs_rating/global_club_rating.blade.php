<input type="hidden" value="{{isset($rating_data)?$rating_data:''}}" id="data">

<section class=" Tab RatingCL m-b-130" ng-controller="rating2Ctrl" ng-cloak>
    <div class="container" ng-controller="gallery_archiveCtrl">

        <!--[ BTN ]-->

        <div class="title_CL" style="margin-left: 0;">{{trans('clubs.rating')}}</div>
        @if(isset($tournament->rating_overview) && $tournament->rating_overview)
            <div style="padding-left: 37px;padding-bottom: 25px;">{{$tournament->rating_overview}}</div>
        @endif

        <div class="TablWr">
            <div class="toolbar">
                <div class="members">{{trans('clubs.members')}}: @{{ filterFun.length ? filterFun.length : 0 }}</div>
                @if(isset($seasons[0]) && $seasons)
                    <div class="form-group" style="text-align: center;">
                        <label for="sel">{{trans('clubs.seasons_list')}}:</label>
                        <select id="select_season" class="form-control" name="sel" style="color: black;">

                            <option value="zero">{{trans('clubs.all_seasons')}}</option>
                            @foreach($seasons as $season)
                                <option title="{{$season->start}}" value="{{$season->id}}"
                                        name="{{$season->end}}">{{$season->title}}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <h4 style="text-align: center;">{{trans('clubs.all_seasons')}}</h4>
                @endif
            </div>
            <!--[ TABLE ]-->

            <div class="Rating_table" ng-show="visible">
                <div class="table_content">
                    <table class="body" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                        <tr>
                            <th>#</th>
                            <th width="15%"><span>Player's Full Name </span></th>
                            <th width="15%"><span>Nickname</span></th>
                            <th><span>Player's Main Club</span></th>
                            <th>
                                <span>Total Played Games (Total Won)</span>
                                <svg  width="1em" height="1em" viewBox="0 0 16 16"
                                     class="bi bi-box-arrow-right svg-icon" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M11.646 11.354a.5.5 0 0 1 0-.708L14.293 8l-2.647-2.646a.5.5 0 0 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                                    <path fill-rule="evenodd"
                                          d="M4.5 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                                    <path fill-rule="evenodd"
                                          d="M2 13.5A1.5 1.5 0 0 1 .5 12V4A1.5 1.5 0 0 1 2 2.5h7A1.5 1.5 0 0 1 10.5 4v1.5a.5.5 0 0 1-1 0V4a.5.5 0 0 0-.5-.5H2a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 1 1 0V12A1.5 1.5 0 0 1 9 13.5H2z"/>
                                </svg>
                                <a href="javascript:void(0)" onclick="ratingClick()"  id="svg" class="tooltip" title="Click here to reveal all roles">pellentesque</a>
                            </th>
                            <th class="thead" style="display: none"><span>Citizen (Win)</span></th>
                            <th class="thead" style="display: none"><span>Mafia (Win)</span></th>
                            <th class="thead" style="display: none"><span>Sheriff (Win)</span></th>
                            <th class="thead" style="display: none"><span>Don (Win)</span></th>
                            <th><span>BM</span></th>
                            <th><span>BP</span></th>
                            <th><span>Prima Nota Points</span></th>
                            <th><span>Total Points</span></th>
                            <th><span>Score</span></th>
                        </tr>
                        <tr class="animate_repeat"
                            ng-repeat="user in filterFun = (users | filter:query | orderBy:sortType:sortReverse)">
                            <th><span>@{{$index + 1}}</span></th>
                            <th>@{{user.Player}}</th>
                            <th>@{{user.Nickname}}</th>
                            <th>@{{ user.Club }}</th>
                            <th>@{{user.Game}} (@{{(user.WR - user.Sheriff_Win) + (user.WB - user.Don_Win) +
                                (user.Sheriff_Win) + (user.Don_Win)}})
                            </th>
                            <th class="thead" style="text-align: center; display: none">@{{user.Citizen }} (@{{user.WR -
                                user.Sheriff_Win}})
                            </th>
                            <th class="thead" style="text-align: center; display: none">@{{user.Mafia}} (@{{user.WB -
                                user.Don_Win}})
                            </th>
                            <th class="thead" style="text-align: center; display: none">@{{user.Sheriff}}
                                (@{{user.Sheriff_Win}})
                            </th>
                            <th class="thead" style="text-align: center; display: none">@{{user.Don}}
                                (@{{user.Don_Win}})
                            </th>
                            <th>@{{user.BM}}</th>
                            <th>@{{user.BP}}</th>
                            <th>@{{ user.PN }}</th>
                            @php

                                    @endphp
                            <th>@{{user.Balls}}</th>
                            <th>@{{user.Score | number:2}}</th>
                        </tr>

                        <tbody ng-if="filterFun.length == 0">
                        <tr class="animate_repeat">
                            <td colspan="8">
                                <i class="fa fa-exclamation-circle text-red" aria-hidden="true"></i>&#160;&#160;
                                <strong class="text-red">{{trans('clubs.no_results')}}</strong>
                            </td>
                        </tr>
                        </tbody>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    function ratingClick() {
        $(".thead").toggle()
    }
</script>

<style>
    .svg-icon{
        position: absolute;
        font-size: 18px;
    }

    .tooltipSvg{
        position: absolute;
    }

    .tooltip {
        display: inline;
    }

    .tooltip:hover {
        color: #c00;
        text-decoration: none;
    }

    .tooltip:hover:after {
        background: #111;
        background: rgba(0, 0, 0, .8);
        border-radius: .5em;
        bottom: 1.35em;
        color: #fff;
        content: attr(title);
        display: block;
        left: 1em;
        padding: .3em 1em;
        position: absolute;
        text-shadow: 0 1px 0 #000;
        white-space: nowrap;
        z-index: 98;
    }

    .tooltip:hover:before {
        border: solid;
        border-color: #111 transparent;
        border-color: rgba(0, 0, 0, .8) transparent;
        border-width: .4em .4em 0 .4em;
        bottom: 1em;
        content: "";
        display: block;
        left: 2em;
        z-index: 99;
    }
</style>
