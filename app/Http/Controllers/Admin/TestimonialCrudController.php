<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TestimonialRequest as StoreRequest;
use App\Http\Requests\TestimonialRequest as UpdateRequest;

class TestimonialCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Testimonial");
        $this->crud->setRoute("admin/testimonial");
        $this->crud->setEntityNameStrings('testimonial', 'testimonials');
    }

    public function setUp()
    {


        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setFromDb();

        // CRUD FIELDS
        $this->crud->addField([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'image',
            'upload' => true,
            'crop' => true,
            'aspect_ratio' => 1,
            'default' => 'build/img/not_img.jpg',
        ]);

        // CRUD COLUMNS
        $this->crud->removeColumn('image');

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
