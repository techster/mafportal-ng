<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ThumbnailRequest as StoreRequest;
use App\Http\Requests\ThumbnailRequest as UpdateRequest;

class ThumbnailCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\GenSetting");
        $this->crud->setRoute("admin/thumb_image");
        $this->crud->setEntityNameStrings('thumbnail', 'thumbnails');
    }

    public function setUp()
    {
        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->addField([
            'name' => 'value',
            'label' => 'Image',
            'type' => 'image',
            'upload' => true,
            'crop' => true,
            'aspect_ratio' => 1.5,
            'default' => 'build/img/not_img.jpg',
        ], 'update');

        $this->crud->addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'text',
        ], 'update');

        $this->crud->addField([
            'name' => 'title',
            'label' => 'Title',
            'type' => 'text',
        ], 'update');

        // CRUD COLUMNS

        $this->crud->addColumn([
            'name' => 'option',
            'label' => "Option",
            'type' => 'text',
        ]);

        $this->crud->removeButton( 'delete' );
        $this->crud->removeButton('create');
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
