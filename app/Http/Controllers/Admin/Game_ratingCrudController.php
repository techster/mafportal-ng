<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game_rating;
use App\Models\Season;
use App\User;
use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Game_ratingRequest as StoreRequest;
use App\Http\Requests\Game_ratingRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use stdClass;

class Game_ratingCrudController extends CrudController
{

    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Game_rating');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/create-game-results');
        $this->crud->setEntityNameStrings('game rating', 'game ratings');
    }

    public function setUp()
    {
    	$uri = Config::get('app.locale')."/api/user";

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // Фильтр для админов клуба
        if( !Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']) ){
            $this->crud->addClause('join', 'club_user', function ($query) {
                $query->on('game_ratings.club_id', '=', 'club_user.club_id')
                    ->where('club_user.user_id', '=', Auth::user()->id)
                    ->where('club_user.admin', '=', 1)
                ;
            });
        }

        $this->crud->addField([
            'name' => 'title',
            'label' => 'Title',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => 'Slug',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => 'Club',
            'type' => 'select',
            'name' => 'club_id',
            'entity' => 'club',
            'attribute' => 'title',
            'model' => 'App\Models\Club',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => 'Tournament',
            'type' => 'select',
            'name' => 'tournament_id',
            'entity' => 'tournament',
            'attribute' => 'title',
            'model' => "App\Models\Tournament",
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => 'Rating table',
            'type' => 'select',
            'name' => 'table_ratings_id',
            'entity' => 'table_ratings',
            'attribute' => 'title',
            'model' => "App\Models\Table_rating",
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'created_at',
            'label' => 'Date',
            'type' => 'datetime_picker',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'moderator',
            'label' => "Moderator",
            'type' => "select2_from_ajax",
            'entity' => 'user',
            'attribute' => "last_name",
            'attribute2' => "name",
            'attribute3' => "nickname",
            'model' => "App\User",
            'data_source' => url($uri),
            'placeholder' => "Select moderator",
            'minimum_input_length' => 1,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ]
        ]);

        $this->crud->addField([
            'name' => 'results',
            'label' => 'Results',
            'type' => 'table_players',
            'entity_singular' => 'player',
            'columns' => [
                'player' => 'Player',
                'role' => 'Role',
                'penalty' => 'Add.Points',
            ],
            'min' => 10,
            'max' => 10,
        ]);

        $this->crud->addField([
            'name' => 'sentence',
            'label' => "The outcome of the game",
            'type' => 'select_from_array',
            'options' => [
                '0' => 'DRAW',
                '1' => 'CITIZENS WON',
                '2' => 'MAFIA WON',
            ],
            'allows_null' => false, // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

        $this->crud->addField([
            'name' => 'best_move',
            'label' => "Best move",
            'type' => "select2_from_ajax",
            'entity' => 'user',
            'attribute' => "last_name",
            'attribute2' => "name",
            'attribute3' => "nickname",
            'model' => "App\User",
            'data_source' => url($uri),
            'placeholder' => "Select player",
            'minimum_input_length' => 1,
        ]);

        $this->crud->addField([
            'name' => 'best_move2',
            'label' => "Best move 2",
            'type' => "select2_from_ajax",
            'entity' => 'user',
            'attribute' => "last_name",
            'attribute2' => "name",
            'attribute3' => "nickname",
            'model' => "App\User",
            'data_source' => url($uri),
            'placeholder' => "Select player",
            'minimum_input_length' => 1,
        ]);

        $this->crud->addField([
            'name' => 'best_player',
            'label' => "Best player",
            'type' => "select2_from_ajax",
            'entity' => 'user',
            'attribute' => "last_name",
            'attribute2' => "name",
            'attribute3' => "nickname",
            'model' => "App\User",
            'data_source' => url($uri),
            'placeholder' => "Select player",
            'minimum_input_length' => 1,
        ]);

//        $this->crud->addField([
//            'name' => 'cool_citizen',
//            'label' => "Cool citizen",
//            'type' => "select2_from_ajax",
//            'entity' => 'user',
//            'attribute' => "last_name",
//            'attribute2' => "name",
//            'attribute3' => "nickname",
//            'model' => "App\User",
//            'data_source' => url($uri),
//            'placeholder' => "Select player",
//            'minimum_input_length' => 1,
//        ]);


        $this->crud->addField([
            'name' => 'prima_nota',
            'label' => "Prima nota",
            'type' => "select2_from_ajax",
            'entity' => 'user',
            'attribute' => "last_name",
            'attribute2' => "name",
            'attribute3' => "nickname",
            'model' => "App\User",
            'data_source' => url($uri),
            'placeholder' => "Select player",
            'minimum_input_length' => 1,
        ]);

        $this->crud->addField([
            'name' => 'select_prima',
            'label' => "Mafia guessed",
            'type' => 'select_from_array',
            'options' => [
                '3' => '3',
                '2' => '2',
            ],
            'allows_null' => false, // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);

//        $this->crud->addField([
//            'name' => 'extra_12',
//            'label' => "Citizens clean win",
//            'type' => 'checkbox',
//            'fake' => true,
//            'store_in' => 'extra_field',
//        ]);

//        $this->crud->addField([
//            'name' => 'extra_13',
//            'label' => "Mafia clean win",
//            'type' => 'checkbox',
//            'fake' => true,
//            'store_in' => 'extra_field',
//        ]);

        // CRUD COLUMNS; ============================================
        $this->crud->addColumn([
            'label' => "Date",
            'name' => 'created_at',
        ]);

        $this->crud->addColumn([
            'name' => 'title',
            'label' => 'Title',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'label' => "Club",
            'type' => "select",
            'name' => 'club_id',
            'entity' => 'club',
            'attribute' => "title",
            'model' => "App\Models\Club",
        ]);

        $this->crud->addColumn([
            'label' => "Tournament",
            'type' => "select",
            'name' => 'tournament_id',
            'entity' => 'tournament',
            'attribute' => "title",
            'model' => "App\Models\Tournament",
        ]);

        $this->crud->addColumn([
            'label' => 'Rating table',
            'type' => 'select',
            'name' => 'table_ratings_id',
            'entity' => 'table_ratings',
            'attribute' => 'title',
            'model' => "App\Models\Table_rating"
        ]);

        $this->crud->orderBy('created_at','desc');

        $this->crud->addFilter([ // dropdown filter
            'name' => 'created_at',
            'type' => 'select2_ratings',
            'label'=> 'Seasons'
        ],  function() {
            if( !Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']) ){
                return \App\Models\Season::join('club_user', 'seasons.club_id', '=', 'club_user.club_id')->where('club_user.user_id', Auth::user()->id)->orderBy('end', 'desc')->get()->pluck('title', 'end')->toArray();
            }

            return \App\Models\Season::all()->sortByDesc("end")->pluck('title', 'end')->toArray();
        }, function($value) { // if the filter is active


            $starts = \App\Models\Season::where('end', $value)->get();
            $start = $starts[0]->start;
            $this->crud->addClause('where', 'created_at', '>', $start);
            $this->crud->addClause('where', 'created_at', '<', $value);


        });

        $this->crud->addFilter([ // select2 filter
            'name' => 'club_id',
            'type' => 'select2',
            'label'=> 'Club'
        ], function() {
            if( !Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']) ){
                return \App\Models\Club::join('club_user', 'seasons.club_id', '=', 'club_user.club_id')->where('club_user.user_id', Auth::user()->id)->get()->pluck('title', 'id')->toArray();
            }

            return \App\Models\Club::all()->pluck('title', 'id')->toArray();

        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'club_id', '=',$value);
        });

        $this->crud->addFilter([ // select2 filter
            'name' => 'tournament_id',
            'type' => 'select2',
            'label'=> 'Tournament'
        ], function() {
            if( !Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']) ){
                return \App\Models\Tournament::join('club_user', 'seasons.club_id', '=', 'club_user.club_id')->where('club_user.user_id', Auth::user()->id)->get()->pluck('title', 'id')->toArray();
            }

            return \App\Models\Tournament::all()->pluck('title', 'id')->toArray();

        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'tournament_id', '=',$value);
        });


    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $this->extra_fields($request->input('id'));
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
