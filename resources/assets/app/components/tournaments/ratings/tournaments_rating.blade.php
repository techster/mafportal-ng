<input type="hidden" value="{{isset($rating_data)?$rating_data:''}}" id="data">

<div class="Tab RatingCL m-t-100 m-b-130" ng-controller="rating2Ctrl" ng-cloak>
    <div class="container">
        <div class="title_CL">{{trans('clubs.rating')}}</div>
        @if(isset($tournament->rating_overview) && $tournament->rating_overview)
            <div style="padding-left: 37px;padding-bottom: 25px;">{{$tournament->rating_overview}}</div>
        @endif

        <div class="TablWr">
            <div class="toolbar">
                <div class="members">{{trans('clubs.members')}}: @{{ filterFun.length ? filterFun.length : 0 }}</div>
            </div>
            <!--[ TABLE ]-->
            <div class="Rating_table">
                <div class="table_content">
                    <table class="body" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                        <tr class="rating-header">
                            <th>#</th>
                            <th><span>Player</span></th>
                            <th>
                                <span>
                                   Games (Won)
                                </span>
                            </th>
                            <th><span class="role-header" title="Citizen (Win)" aria-label="Citizen (Win)"><i class="fa fa-users" aria-hidden="true"></i></span></th>
                            <th><span class="role-header" title="Mafia (Win)" aria-label="Mafia (Win)"><i class="fa fa-user-secret" aria-hidden="true"></i></span></th>
                            <th><span class="role-header" title="Sheriff (Win)" aria-label="Sheriff (Win)"><i class="fa fa-star" aria-hidden="true"></i></span></th>
                            <th><span class="role-header" title="Don (Win)" aria-label="Don (Win)"><i class="fa fa-gavel" aria-hidden="true"></i></span></th>
                            <th><span>BM</span>
                            </th>
                            <th><span>BP</span>
                            </th>
                            <th><span>PN</span>
                            </th>
                            <th><span>Points</span></th>
                            <th><span>Score</span></th>
                        </tr>
                        <tr class="animate_repeat"
                            ng-repeat="user in filterFun = (users | filter:query | orderBy:sortType:sortReverse)">
                            <th><span>@{{$index + 1}}</span></th>
                                <th>
                                <span class="player-cell">
                                <img ng-src="@{{user.Avatar}}" class="player-avatar" alt="">
                                <span class="player-details">
                                    @{{user.Player}}@{{user.Nickname ? ' (' + user.Nickname + ')' : ''}}
                                    <span class="player-main-club">@{{user.Main_Club}}</span>
                                </span>
                                </span>
                                </th>
                            <th>@{{user.Game}} (@{{(user.WR - user.Sheriff_Win) + (user.WB - user.Don_Win) +
                                (user.Sheriff_Win) + (user.Don_Win)}})
                            </th>
                            <th>@{{user.Citizen}} (@{{user.WR - user.Sheriff_Win}})</th>
                            <th>@{{user.Mafia}} (@{{user.WB - user.Don_Win}})</th>
                            <th>@{{user.Sheriff}} (@{{user.Sheriff_Win}})</th>
                            <th>@{{user.Don}} (@{{user.Don_Win}})</th>
                            <th>@{{user.BM}}</th>
                            <th>@{{user.BP}}</th>
                            <th>@{{user.PN}}</th>
                            <th>@{{user.Balls}}</th>
                            <th>@{{user.Score | number:2}}</th>
                        </tr>

                        <tbody ng-if="filterFun.length == 0">
                        <tr class="animate_repeat">
                            <td colspan="12">
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
</div>
<style>
    .Rating_table .rating-header {
        color: #c00;
    }

    .role-header {
        display: inline-block;
        min-width: 28px;
        text-align: center;
        font-size: 18px;
    }

    .Rating_table .body th:nth-child(2) {
        min-width: 260px;
        white-space: nowrap;
    }

    .player-main-club {
        display: block;
        color: #999;
        font-size: 0.85em;
    }

    .player-avatar {
        display: inline-block;
        flex: 0 0 42px;
        width: 42px;
        height: 42px;
        margin-right: 8px;
        border-radius: 50%;
        object-fit: cover;
        vertical-align: middle;
    }

    .player-cell {
        display: inline-flex !important;
        flex-direction: row;
        align-items: center;
        flex-wrap: nowrap;
        height: 42px;
        white-space: nowrap;
        vertical-align: middle;
    }

    .player-avatar-fallback {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: #9aa3ad;
        font-size: 22px;
    }

    .player-details {
        display: inline-flex;
        flex-direction: column;
        justify-content: center;
        flex: 0 0 auto;
        height: 42px;
        line-height: 21px;
        white-space: nowrap;
    }

</style>
