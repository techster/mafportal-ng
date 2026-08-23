<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\NewsRequest as StoreRequest;
use App\Http\Requests\NewsRequest as UpdateRequest;

class NewsCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\News");
        $this->crud->setRoute("admin/news");
        $this->crud->setEntityNameStrings('news', 'news');
    }

    public function setUp()
    {
        // Eng
        $this->crud->addField([
            'name' => 'title',
            'label' => "Title",
            'type' => 'text',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => "Slug",
            'type' => 'text',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'created_at',
            'label' => 'Date',
            'type' => 'datetime_picker',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'image',
            'upload' => true,
            'crop' => true,
            'aspect_ratio' => 3,
            'default' => 'build/img/not_img.jpg',
            'tab' => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
            'tab' => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'text',
            'label' => 'Text',
            'type' => 'ckeditor',
            'tab' => 'Eng',
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


        // CRUD COLUMNS
        $this->crud->addColumn([
            'label' => "Data",
            'name' => 'created_at',
        ]);

        $this->crud->addColumn([
            'name' => 'title',
            'label' => "Title",
            'type' => 'Text',
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
