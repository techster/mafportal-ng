<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RatingRequest as StoreRequest;
use App\Http\Requests\RatingRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;

class RatingListCrudController extends CrudController
{

    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Rating');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/rating-list');
        $this->crud->setEntityNameStrings('table rating', 'table ratings');
    }

    public function setUp()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->orderby('balls', 'desc');

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'player',
            'label' => 'Player',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'club',
            'label' => 'Club',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'game',
            'label' => 'Games',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'win',
            'label' => 'Games(Win)',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'citizen',
            'label' => 'Citizen (Win)',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'mafia',
            'label' => 'Mafia (Win)',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'sheriff',
            'label' => 'Sheriff',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'sheriff_win',
            'label' => 'Sheriff (Win)',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'don',
            'label' => 'Don',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'don_win',
            'label' => 'Don (Win)',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'bm',
            'label' => 'BM',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'bp',
            'label' => 'BP',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'balls',
            'label' => 'Points',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'score',
            'label' => 'Score',
            'type' => 'text'
        ]);

        // CRUD COLUMNS;
        $this->crud->addColumn([
            'name' => 'player',
            'label' => 'Player',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'club',
            'label' => 'club',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'game',
            'label' => 'Games',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'win',
            'label' => 'Games(Win)',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'citizen',
            'label' => 'Citizen (Win)',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'mafia',
            'label' => 'Mafia (Win)',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'sheriff',
            'label' => 'Sheriff',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'sheriff_win',
            'label' => 'Sheriff (Win)',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'don',
            'label' => 'Don',
            'type' => 'Text'
        ]);


        $this->crud->addColumn([
            'name' => 'don_win',
            'label' => 'Don (Win)',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'bm',
            'label' => 'BM',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'bp',
            'label' => 'BP',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'balls',
            'label' => 'Points',
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'score',
            'label' => 'Score',
            'type' => 'Text'
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
