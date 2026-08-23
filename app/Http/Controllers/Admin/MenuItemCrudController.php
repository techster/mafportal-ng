<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MenuItemRequest as StoreRequest;
use App\Http\Requests\MenuItemRequest as UpdateRequest;

class MenuItemCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        $this->crud->setModel("App\Models\MenuItem");
        $this->crud->setRoute(config('backpack.base.route_prefix').'/menu-item');
        $this->crud->setEntityNameStrings('menu item', 'menu items');

        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Label',
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'name_rus',
            'label' => 'Russian label',
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'label' => 'Parent',
            'type' => 'select',
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'name',
            'model' => "\Backpack\MenuCRUD\app\Models\MenuItem",
        ]);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Label',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'name_rus',
            'label' => 'Russian label',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'label' => 'Parent',
            'type' => 'select',
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'name',
            'model' => "\Backpack\MenuCRUD\app\Models\MenuItem",
        ]);

        $this->crud->addField([
            'name' => 'link_type',
            'label' => 'Link Type',
            'type' => 'select_from_array',
            'options' => ['self' => 'Self (default)', 'new' => 'New window'],
        ]);

        $this->crud->addField([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'page_or_link',
            'page_model' => '\Backpack\PageManager\app\Models\Page',
        ]);
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud($request);
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud($request);
    }
}
