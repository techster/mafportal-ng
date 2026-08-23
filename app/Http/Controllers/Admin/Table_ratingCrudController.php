<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Table_ratingRequest as StoreRequest;
use App\Http\Requests\Table_ratingRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;

class Table_ratingCrudController extends CrudController
{

    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Table_rating');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/create-table-ratings');
        $this->crud->setEntityNameStrings('table rating', 'table ratings');
    }

    public function setUp()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // Фильтр для админов клуба
        if( !Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']) ){
            $this->crud->addClause('join', 'club_user', function ($query) {
                $query->on('table_ratings.club_id', '=', 'club_user.club_id')
                    ->where('club_user.user_id', '=', Auth::user()->id)
                    ->where('club_user.admin', '=', 1)
                ;
            });
        }

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'title',
            'label' => 'Title',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'label' => 'Club',
            'type' => 'select',
            'name' => 'club_id',
            'entity' => 'club',
            'attribute' => 'title',
            'model' => 'App\Models\Club',
        ]);

        $this->crud->addField([
            'name' => 'check_glob',
            'label' => 'Show in global?',
            'type' => 'checkbox',
        ]);

        // Балы
        $this->crud->addField([
            'name' => 'win_citizen',
            'label' => 'Win: Citizen',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#1#',
        ]);

        $this->crud->addField([
            'name' => 'win_sheriff',
            'label' => 'Win: Sheriff',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#2#',
        ]);

        $this->crud->addField([
            'name' => 'win_mafia',
            'label' => 'Win: Mafia',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#3#',
        ]);

        $this->crud->addField([
            'name' => 'win_don',
            'label' => 'Win: Don',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#4#',
        ]);

        $this->crud->addField([
            'name' => 'fail_citizen',
            'label' => 'Fail: Citizen',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#5#',
        ]);

        $this->crud->addField([
            'name' => 'fail_sheriff',
            'label' => 'Fail: Sheriff',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#6#',
        ]);

        $this->crud->addField([
            'name' => 'fail_mafia',
            'label' => 'Fail: Mafia',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#7#',
        ]);

        $this->crud->addField([
            'name' => 'fail_don',
            'label' => 'Fail: Don',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#8#',
        ]);

        $this->crud->addField([
            'name' => 'best_player',
            'label' => 'Best Player',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#9#',
        ]);

        $this->crud->addField([
            'name' => 'best_step',
            'label' => 'Best Move',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#10#',
        ]);

        $this->crud->addField([
            'name' => 'prima_nota3',
            'label' => 'Prima nota (3)',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#12#',
        ]);

        $this->crud->addField([
            'name' => 'prima_nota2',
            'label' => 'Prima nota (2)',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-3'
            ],
            'prefix' => '#13#',
        ]);

        $this->crud->addField([
            'name' => 'extra_field',
            'label' => 'Extra fields',
            'type' => 'table_rating',
            'entity_singular' => 'option',
            'columns' => [
                'id' => 'ID',
                'name' => 'Name',
                'points' => 'Points',
                'condition1' => 'Role',
                'condition2' => 'Result',
                'type' => 'Type',
            ],
            'max' => 999,
            'min' => 0
        ]);

        $this->crud->addField([
            'name' => 'formula',
            'label' => 'Formula',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ]
        ]);

        // CRUD COLUMNS;
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
            'name' => 'check_glob',
            'label' => 'Show in global?',
            'type' => 'check'
        ]);

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
