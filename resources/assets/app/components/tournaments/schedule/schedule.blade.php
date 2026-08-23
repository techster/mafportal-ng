<input type="hidden" value="{{isset($rating_data)?$rating_data:''}}" id="data">

<div class="Tab RatingCL m-b-100" ng-controller="ratingCtrl" ng-cloak>
    <div class="container">
        @foreach($tournament->game_ratings as $key => $game)
            <div class="m-b-60 col-xs-12 col-md-6">
                <div class="title_CL">{{$game->title}}</div>
                <div class="TablWr">
                    <!--[ TABLE ]-->
                    <div class="Rating_table">
                        <div class="table_content">
                            <table class="body" cellpadding="0" cellspacing="0" border="0">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th><span class="ar" ng-click="sortType = 'Player';     sortReverse = !sortReverse">Player</span></th>
                                        <th><span class="ar" ng-click="sortType = 'Role';       sortReverse = !sortReverse">Role</span></th>
                                        <th><span class="ar" ng-click="sortType = 'Result';     sortReverse = !sortReverse">Result</span></th>
                                        <th><span class="ar" ng-click="sortType = 'Points';     sortReverse = !sortReverse">Points</span></th>
                                        <th><span class="ar" ng-click="sortType = 'Add_Points'; sortReverse = !sortReverse">Add. Points</span></th>
                                    </tr>
                                    <tr class="animate_repeat"
                                        ng-repeat="user in filterFun = (users[{{$game->id}}] | filter:query | orderBy:sortType:sortReverse)">
                                        <th><span>@{{$index + 1}}</span></th>
                                        <th>@{{user.Player}}</th>
                                        <th>@{{user.Role}}</th>
                                        <th>@{{user.Result}}</th>
                                        <th>@{{user.Points}}</th>
                                        <th>@{{user.Add_Points}}</th>
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
        @endforeach
    </div>
</div>