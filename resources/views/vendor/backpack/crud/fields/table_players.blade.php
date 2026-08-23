<!-- array input -->
<?php
$max = isset($field['max']) && (int)$field['max'] > 0 ? $field['max'] : -1;
$min = isset($field['min']) && (int)$field['min'] > 0 ? $field['min'] : -1;
$item_name = strtolower(isset($field['entity_singular']) && !empty($field['entity_singular']) ? $field['entity_singular'] : $field['label']);

$items = old($field['name']) ? (old($field['name'])) : (isset($field['value']) ? ($field['value']) : (isset($field['default']) ? ($field['default']) : ''));

// make sure not matter the attribute casting
// the $items variable contains a properly defined JSON
if (is_array($items)) {
    if (count($items)) {
        $items = json_encode($items);
    } else {
        $items = '[]';
    }
} elseif (is_string($items) && !is_array(json_decode($items))) {
    $items = '[]';
}

$field['attribute'] = "last_name";
$field['attribute2'] = "name";
$field['attribute3'] = "nickname";
?>
<div ng-app="backPackTableApp" ng-controller="tableController" @include('crud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <input class="array-json" type="hidden" id="{{ $field['name'] }}" name="{{ $field['name'] }}">

    <div class="array-container form-group">

        <table class="table table-bordered table-striped m-b-0"
               ng-init="field = '#{{ $field['name'] }}'; items = {{ $items }}; max = {{$max}}; min = {{$min}}; maxErrorTitle = '{{trans('backpack::crud.table_cant_add', ['entity' => $item_name])}}'; maxErrorMessage = '{{trans('backpack::crud.table_max_reached', ['max' => $max])}}'">

            <thead>
            <tr>
                <th>№</th>
                @foreach( $field['columns'] as $prop )
                    <th style="font-weight: 600!important;">
                        {{ $prop }}
                    </th>
                @endforeach
                <th class="text-center" ng-if="max == -1 || max > 1"> {{-- <i class="fa fa-sort"></i> --}} </th>
                <th class="text-center" ng-if="max == -1 || max > 1"> {{-- <i class="fa fa-trash"></i> --}} </th>
            </tr>
            </thead>

            <tbody ui-sortable="sortableOptions" ng-model="items" class="table-striped">

            <tr ng-repeat="item in items" class="array-row">

                <td><% $index+1 %></td>
                @foreach( $field['columns'] as $prop => $label)
                    <td>
                        @if($prop == 'player')
                            <input
                                    type="text"
                                    class="form-control input-sm select2_ajax_player"
                                    ng-model="item.{{ $prop }}"
                            >
                        @endif

                        @if($prop == 'role')
                            <select class="form-control input-sm" ng-model="item.{{ $prop }}"
                                    ng-init="item.{{ $prop }} = item.{{ $prop }} || '1'">
                                <option value="0">Select role</option>
                                <option value="1">Citizen</option>
                                <option value="2">Sheriff</option>
                                <option value="3">Mafia</option>
                                <option value="4">Don</option>
                            </select>
                        @endif

                        @if($prop == 'penalty')
                            <input style="width: 50px;" class="form-control input-sm" type="text"
                                   ng-model="item.{{ $prop }}">
                        @endif

                        {{--@if($prop == 'best_move')--}}
                        {{--<select class="form-control input-sm" ng-model="item.{{ $prop }}"--}}
                        {{--ng-init="item.{{ $prop }} = item.{{ $prop }} || '0'">--}}
                        {{--<option value="1">Да</option>--}}
                        {{--<option value="0">Нет</option>--}}
                        {{--</select>--}}
                        {{--@endif--}}

                        {{--@if($prop == 'best_player')--}}
                        {{--<select class="form-control input-sm" ng-model="item.{{ $prop }}"--}}
                        {{--ng-init="item.{{ $prop }} = item.{{ $prop }} || '0'">--}}
                        {{--<option value="1">Да</option>--}}
                        {{--<option value="0">Нет</option>--}}
                        {{--</select>--}}
                        {{--@endif--}}

                        {{--@if($prop == 'cool_citizen')--}}
                        {{--<select class="form-control input-sm" ng-model="item.{{ $prop }}"--}}
                        {{--ng-init="item.{{ $prop }} = item.{{ $prop }} || '0'">--}}
                        {{--<option value="1">Да</option>--}}
                        {{--<option value="0">Нет</option>--}}
                        {{--</select>--}}
                        {{--@endif--}}
                    </td>
                @endforeach
                <td ng-if="max == -1 || max > 1">
                    <span class="btn btn-sm btn-default sort-handle"><span class="sr-only">sort item</span><i
                                class="fa fa-sort" role="presentation" aria-hidden="true"></i></span>
                </td>
                <td ng-if="max == -1 || max > 1">
                    <button ng-hide="min > -1 && $index < min" class="btn btn-sm btn-default" type="button"
                            ng-click="removeItem(item);"><span class="sr-only">delete item</span><i class="fa fa-trash"
                                                                                                    role="presentation"
                                                                                                    aria-hidden="true"></i>
                    </button>
                </td>
            </tr>

            </tbody>

        </table>

        <div class="array-controls btn-group m-t-10">
            <button ng-if="max == -1 || items.length < max" class="btn btn-sm btn-default" type="button"
                    ng-click="addItem()">
                <i class="fa fa-plus"></i>
                {{trans('backpack::crud.add')}} {{ $item_name }}
            </button>
        </div>

    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


{{-- Скрипты для ajax селектора --}}
@php
    $connected_entity = new App\User;
    $connected_entity_key_name = $connected_entity->getKeyName();
@endphp
@push('crud_fields_scripts')
    <script>
        function table_players() {
            $(".select2_ajax_{{'player'}}").each(function (i, obj) {
                if (!$(obj).data("select2")) {
                    $(obj).select2({
                        placeholder: "Select player",
                        minimumInputLength: "1",
                        ajax: {
                            url: "{{ url(Config::get('app.locale')."/api/user") }}",
                            dataType: 'json',
                            quietMillis: 250,
                            data: function (term, page) {
                                return {
                                    q: term, // search term
                                    page: page
                                };
                            },
                            results: function (data, params) {
                                params.page = params.page || 1;

                                var result = {
                                    results: $.map(data.data, function (item) {
                                        textField = "{{$field['attribute']}}";
                                        textField2 = "{{isset($field['attribute2'])?$field['attribute2']:''}}";
                                        textField3 = "{{isset($field['attribute3'])?$field['attribute3']:''}}";
                                        return {
                                            text: item[textField2] + (item[textField] ? ' ' + item[textField] : '') + (item[textField3] ? ' (' + item[textField3] + ')' : ''),
                                            id: item["{{ $connected_entity_key_name }}"]
                                        }
                                    }),
                                    more: data.current_page < data.last_page
                                };

                                return result;
                            },
                            cache: true
                        },
                        initSelection: function (element, callback) {
                            $.ajax("{{ url('api/user') }}" + '/' + element[0].value, {
                                dataType: "json"
                            }).done(function (data) {
                                textField = "{{$field['attribute']}}";
                                textField2 = "{{isset($field['attribute2'])?$field['attribute2']:''}}";
                                textField3 = "{{isset($field['attribute3'])?$field['attribute3']:''}}";
                                callback({
                                    text: data[textField2] + (data[textField] ? ' ' + data[textField] : '') + (data[textField3] ? ' (' + data[textField3] + ')' : ''),
                                    id: data["{{ $connected_entity_key_name }}"]
                                });
                            });
                        },
                    });
                }
            });
        }

        jQuery(document).ready(function ($) {
//        table_players();
            setTimeout(function () {
                table_players();
            }, 500);
        });
    </script>
@endpush



{{-- Скрипты для таблицы --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
    @push('crud_fields_styles')
    @endpush
    @push('crud_fields_scripts')
        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>
        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-sortable/0.14.3/sortable.min.js"></script>
        <script>

            window.angularApp = window.angularApp || angular.module('backPackTableApp', ['ui.sortable'], function ($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

            window.angularApp.controller('tableController', function ($scope) {

                $scope.sortableOptions = {
                    handle: '.sort-handle'
                };

                $scope.addItem = function () {
                    var array_keys = $scope.items.map(function (item) {
                        return item.key_id;
                    });
                    var next_key = Math.max.apply(null, array_keys) + 1;
                    if (next_key < 0) next_key = 0;

                    if ($scope.max > -1) {
                        if ($scope.items.length < $scope.max) {
                            var item = {key_id: next_key};
                            $scope.items.push(item);
                        } else {
                            new PNotify({
                                title: $scope.maxErrorTitle,
                                text: $scope.maxErrorMessage,
                                type: 'error'
                            });
                        }
                    }
                    else {
                        var item = {key_id: next_key};
                        $scope.items.push(item);
                    }
                    setTimeout(function () {
                        table_players();
                    }, 500);
                }

                $scope.removeItem = function (item) {
                    var index = $scope.items.indexOf(item);
                    $scope.items.splice(index, 1);
                }

                $scope.$watch('items', function (a, b) {
                    if ($scope.min > -1) {
                        while ($scope.items.length < $scope.min) {
                            $scope.addItem();
                        }
                    }

                    if (typeof $scope.items != 'undefined' && $scope.items.length) {

                        if (typeof $scope.field != 'undefined') {
                            if (typeof $scope.field == 'string') {
                                $scope.field = $($scope.field);
                            }
                            $scope.field.val(angular.toJson($scope.items));
                        }
                    }

                    // Проверяем количество игроков
                    var check_list = {1: [], 2: [], 3: [], 4: []};
                    $scope.items.forEach(function (item) {
                        if (check_list[item.role] !== undefined) check_list[item.role].push(item.key_id);

                        if (check_list[1].length > 6 && item.role == 1) item.role = 0;
                        if (check_list[2].length > 1 && item.role == 2) item.role = 0;
                        if (check_list[3].length > 2 && item.role == 3) item.role = 0;
                        if (check_list[4].length > 1 && item.role == 4) item.role = 0;
                    });

                }, true);

                if ($scope.min > -1) {
                    for (var i = 0; i < $scope.min; i++) {
                        $scope.addItem();
                    }
                }
            });

            angular.element(document).ready(function () {
                angular.forEach(angular.element('[ng-app]'), function (ctrl) {
                    var ctrlDom = angular.element(ctrl);
                    if (!ctrlDom.hasClass('ng-scope')) {
                        angular.bootstrap(ctrl, [ctrlDom.attr('ng-app')]);
                    }
                });
            })
        </script>
    @endpush
@endif
