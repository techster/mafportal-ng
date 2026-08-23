<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Video_galleryRequest as StoreRequest;
use App\Http\Requests\Video_galleryRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;

class Video_galleryCrudController extends CrudController
{

    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Video_gallery');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/video_gallery');
        $this->crud->setEntityNameStrings('video gallery', 'video galleries');
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
                $query->on('video_galleries.club_id', '=', 'club_user.club_id')
                    ->where('club_user.user_id', '=', Auth::user()->id)
                    ->where('club_user.admin', '=', 1)
                ;
            });
        }

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'title',
            'label' => "Title",
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'title_ru',
            'label' => "Russian Title",
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => "Club",
            'type' => 'select',
            'name' => 'club_id',
            'entity' => 'club',
            'attribute' => 'title',
            'model' => "App\Models\Club",
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => "Tournament",
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
            'name' => 'check_glob',
            'label' => 'Show in global gallery?',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'preview',
            'label' => 'Preview',
            'type' => 'image',
            'upload' => true,
            'crop' => true,
            'aspect_ratio' => 1.5,
            'default' => 'build/img/not_img.jpg',
        ]);

        $this->crud->addField([
            'name' => 'id_youtube',
            'label' => 'YouTube ID',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-5'
            ]
        ]);

        // CRUD COLUMNS;
        $this->crud->addColumn([
            'name' => 'title',
            'label' => "Title",
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
            'type' => 'select',
            'name' => 'tournament_id',
            'entity' => 'tournament',
            'attribute' => 'title',
            'model' => "App\Models\Tournament"
        ]);

        $this->crud->addColumn([
            'name' => 'check_glob',
            'label' => "Show in global gallery?",
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
