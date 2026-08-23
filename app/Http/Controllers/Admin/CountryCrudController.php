<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CountryRequest as StoreRequest;
use App\Http\Requests\CountryRequest as UpdateRequest;

class CountryCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Country");
        $this->crud->setRoute("admin/country");
        $this->crud->setEntityNameStrings('country', 'countries');
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
            'tab' => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'image',
            'upload' => true,
            'crop' => true,
            'aspect_ratio' => 1,
            'default' => 'build/img/not_img.jpg',
            'tab' => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'description',
            'label' => 'About',
            'type' => 'ckeditor',
            'tab' => 'Eng',
        ]);

        // Rus
        $this->crud->addField([
            'name' => 'title_ru',
            'label' => "Russian Title",
            'type' => 'text',
            'tab' => 'Rus',
        ]);

        $this->crud->addField([
            'name' => 'description_ru',
            'label' => 'Russian Description',
            'type' => 'ckeditor',
            'tab' => 'Rus',
        ]);

        // Col
        $this->crud->addColumn([
            'name' => 'title',
            'label' => "Title",
            'type' => 'Text',
        ]);

        $this->crud->addColumn([
            'name' => 'description',
            'label' => "Description",
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
