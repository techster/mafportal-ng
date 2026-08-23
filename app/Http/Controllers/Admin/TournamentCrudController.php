<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TournamentRequest as StoreRequest;
use App\Http\Requests\TournamentRequest as UpdateRequest;

class TournamentCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Tournament");
        $this->crud->setRoute("admin/tournament");
        $this->crud->setEntityNameStrings('tournament', 'tournaments');
    }

    public function setUp()
    {
        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        // Eng
        $this->crud->addField([
            'name' => 'title',
            'label' => "Title",
            'type' => 'text',
            'tab'   => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'live',
            'label' => "Youtube Live",
            'type' => 'text',
            'tab'   => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => "Slug",
            'type' => 'text',
            'tab'   => 'Eng',
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
            'tab'   => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'created_at',
            'type' => 'datetime_picker',
            'label' => 'Date',
            'tab'   => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'category',
            'type' => 'select',
            'label' => 'Category',
            'tab'   => 'Eng',
            'model' => "App\Models\Category",
            'entity' => 'parent',
            'attribute' => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'created_at',
            'type' => 'datetime_picker',
            'label' => 'Date',
            'tab'   => 'Eng',
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
            'aspect_ratio' => 1.8,
            'default' => 'build/img/not_img.jpg',
            'tab'   => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'image',
            'upload' => true,
            'crop' => true,
            'aspect_ratio' => 3,
            'default' => 'build/img/not_img.jpg',
            'tab'   => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
            'tab'   => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'rating_overview',
            'label' => 'Rating Overview',
            'type' => 'textarea',
            'tab'   => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'text',
            'label' => 'Text',
            'type' => 'ckeditor',
            'tab'   => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'meta_title',
            'label' => 'Meta Title',
            'type' => 'text',
            'tab'   => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'meta_description',
            'label' => 'Meta Description',
            'type' => 'text',
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
            'name' => 'rating_overview_ru',
            'label' => 'Rating Overview',
            'type' => 'textarea',
            'tab'   => 'Rus',
        ]);
        $this->crud->addField([
            'name' => 'text_ru',
            'label' => 'Text',
            'type' => 'ckeditor',
            'tab' => 'Rus',
        ]);

        $this->crud->addField([
            'name' => 'meta_title_ru',
            'label' => 'Meta Title',
            'type' => 'text',
            'tab'   => 'Rus',
        ]);

        $this->crud->addField([
            'name' => 'meta_description_ru',
            'label' => 'Meta Description',
            'type' => 'text',
            'tab'   => 'Rus',
        ]);

        // CRUD COLUMNS
        $this->crud->addColumn([
            'label' => "Data",
            'name' => 'created_at',
        ]);

        $this->crud->addColumn([
            'name' => 'title',
            'label' => "Title",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'label' => 'Rating table',
            'type' => 'select',
            'name' => 'table_ratings_id',
            'entity' => 'table_ratings',
            'attribute' => 'title',
            'model' => "App\Models\Table_rating"
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
