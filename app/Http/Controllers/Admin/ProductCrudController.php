<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProductRequest as StoreRequest;
use App\Http\Requests\ProductRequest as UpdateRequest;

class ProductCrudController extends CrudController
{

    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Product');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/product');
        $this->crud->setEntityNameStrings('product', 'products');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->addField([
            'name' => 'title',
            'label' => "Title",
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'image',
            'upload' => true,
            'crop' => true,
            'aspect_ratio' => 1,
            'default' => 'build/img/not_img.jpg',
        ]);

        $this->crud->addField([
            'name' => 'description',
            'label' => "Description",
            'type' => 'textarea',
        ]);

        $this->crud->addField([
            'name' => 'price',
            'label' => "Price",
            'type' => 'text',
        ]);

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

        $this->crud->addColumn([
            'name' => 'price',
            'label' => "Price",
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
