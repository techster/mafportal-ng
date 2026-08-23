<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PartnerRequest as StoreRequest;
use App\Http\Requests\PartnerRequest as UpdateRequest;

class PartnerCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Partner");
        $this->crud->setRoute("admin/partner");
        $this->crud->setEntityNameStrings('partner', 'partners');
    }

    public function setUp()
    {
        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

//        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'name',
            'label' => "Name",
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'logo',
            'label' => "Logo",
            'type' => 'image',
            'upload' => true,
            'crop' => true,
            'aspect_ratio' => 0,
            'default' => 'build/img/not_img.jpg',
        ]);

        $this->crud->addField([
            'name' => 'link',
            'label' => "Link",
            'type' => 'text',
        ]);

        $this->crud->addColumn('name');
        $this->crud->addColumn('link');
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
