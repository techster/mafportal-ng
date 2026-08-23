<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EventRequest as StoreRequest;
use App\Http\Requests\EventRequest as UpdateRequest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventCrudController extends CrudController
{

    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Event');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/event');
        $this->crud->setEntityNameStrings('event', 'events');
    }

    public function setUp()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // Фильтр для админов клуба
        if( !Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']) ) {
            $club_ids = Auth::user()->clubs_admin->pluck('id')->toArray();
            $this->crud->addClause('whereHas', 'clubs', function ($query) use ($club_ids) {
                $query->whereIn('id', $club_ids);
            });
        }

        // Eng
        $this->crud->addField([
            'name'  => 'title',
            'label' => 'Title',
            'type'  => 'text',
            'tab'   => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name'  => 'slug',
            'label' => 'Slug',
            'type'  => 'text',
            'tab'   => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name'  => 'created_at',
            'label' => 'Date',
            'type'  => 'datetime_picker',
            'tab'   => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label'     => 'Rating table',
            'type'      => 'select',
            'name'      => 'table_ratings_id',
            'entity'    => 'table_ratings',
            'attribute' => 'title',
            'model'     => "App\Models\Table_rating",
            'tab'       => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label'     => 'Clubs',
            'type'      => 'checklist',
            'name'      => 'clubs',
            'entity'    => 'clubs',
            'attribute' => 'title',
            'model'     => "App\Models\Club",
            'pivot'     => true,
            'tab'       => 'Eng',
        ]);

        $this->crud->addField([
            'name'         => 'image',
            'label'        => 'Image',
            'type'         => 'image',
            'upload'       => true,
            'crop'         => true,
            'aspect_ratio' => 3,
            'default'      => 'build/img/not_img.jpg',
            'tab'          => 'Eng',
        ]);

        $this->crud->addField([
            'name'  => 'description',
            'label' => 'Description',
            'type'  => 'textarea',
            'tab'   => 'Eng',
        ]);

        $this->crud->addField([
            'name'  => 'text',
            'label' => 'Text',
            'type'  => 'ckeditor',
            'tab'   => 'Eng',
        ]);

        // Rus
        $this->crud->addField([
            'name' => 'title_ru',
            'label' => "Title",
            'type' => 'text',
            'tab' => 'Rus',
        ]);

        $this->crud->addField([
            'name' => 'description_ru',
            'label' => 'Description',
            'type' => 'textarea',
            'tab' => 'Rus',
        ]);

        $this->crud->addField([
            'name' => 'text_ru',
            'label' => 'Text',
            'type' => 'ckeditor',
            'tab' => 'Rus',
        ]);

        // Col
        $this->crud->addColumn([
            'label' => "Date",
            'name'  => 'created_at',
        ]);

        $this->crud->addColumn([
            'name'  => 'title', // The db column name
            'label' => "Title", // Table column heading
            'type'  => 'Text'
        ]);

        $this->crud->addColumn([
            'label'     => "Clubs",
            'type'      => 'select_multiple',
            'name'      => 'clubs',
            'entity'    => 'clubs',
            'attribute' => 'title',
            'model'     => "App\Models\Club",
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
