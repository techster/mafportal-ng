<?php

namespace App\Http\Controllers\Admin;

use App\Models\Club;
use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SeasonRequest as StoreRequest;
use App\Http\Requests\SeasonRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class SeasonCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Season");
        $this->crud->setRoute("admin/seasons");
        $this->crud->setEntityNameStrings('season', 'seasons');
    }

    public function setUp()
    {


        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/


        if( !Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']) ){
            $this->crud->addClause('join', 'club_user', function ($query) {
                $query->on('seasons.club_id', '=', 'club_user.club_id')
                    ->where('club_user.user_id', '=', Auth::user()->id)
                    ->where('club_user.admin', '=', 1)
                ;
            });
        }

        $this->crud->addField([
            'name' => 'title',
            'label' => "Title",
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => 'Club',
            'type' => 'select_seasons',
            'name' => 'club_id',
            'entity' => 'club',
            'attribute' => 'title',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'model' => 'App\Models\Club',
        ]);

        $this->crud->addField([
            'name' => 'event_date_range', // a unique name for this field
            'start_name' => 'start', // the db column that holds the start_date
            'end_name' => 'end', // the db column that holds the end_date
            'label' => 'Start - End (Date Range)',
            'type' => 'date_range',
            // OPTIONALS
            'start_default' => date('Y-m-d'), // default value for start_date
            'end_default' => date('Y-m-d'), // default value for end_date
            'date_range_options' => [ // options sent to daterangepicker.js

                'locale' => ['format' => 'DD/MM/YYYY']
            ]
        ]);


        // CRUD COLUMNS;
        $this->crud->addColumn([
            'name' => 'title',
            'label' => 'Title',
            'type' => 'Text_active'
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
            'name' => 'start',
            'label' => 'Start Date',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'end',
            'label' => 'End Date',
            'type' => 'Text'
        ]);

        // filters

        $this->crud->orderBy('end','desc');

        $this->crud->addFilter([ // dropdown filter
            'name' => 'club_id',
            'type' => 'select2',
            'label'=> 'Clubs'
        ],  function() {
            if( !Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']) ){
                return \App\Models\Club::join('club_user', 'clubs.id', '=', 'club_user.club_id')->where('club_user.user_id', Auth::user()->id)->get()->pluck('title', 'id')->toArray();
            }
            return \App\Models\Club::all()->pluck('title', 'id')->toArray();
        }, function($value) { // if the filter is active
            $this->crud->addClause('where', 'seasons.club_id', $value);
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
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
