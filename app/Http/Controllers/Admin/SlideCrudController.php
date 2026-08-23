<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SlideRequest as StoreRequest;
use App\Http\Requests\SlideRequest as UpdateRequest;

class SlideCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Slide");
        $this->crud->setRoute("admin/slide");
        $this->crud->setEntityNameStrings('slide', 'slides');
    }

    public function setUp()
    {
        // Eng
        $this->crud->addField([
            'name' => 'title',
            'label' => "Title",
            'type' => 'text',
            'tab' => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
            'tab' => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'btn_text',
            'label' => "Button text",
            'type' => 'text',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'btn_link',
            'label' => "Button link",
            'type' => 'text',
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
            'aspect_ratio' => 0,
            'default' => 'build/img/not_img.jpg',
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
            'name' => 'btn_text_ru',
            'label' => "Button text",
            'type' => 'text',
            'tab' => 'Rus',
        ]);

        $this->crud->addField([
            'name' => 'btn_link_ru',
            'label' => "Button link",
            'type' => 'text',
            'tab' => 'Rus',
        ]);

        // CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'title',
            'label' => "Title",
            'type' => 'Text'
        ]);

        $this->crud->addColumn([
            'name' => 'description',
            'label' => 'Description',
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
