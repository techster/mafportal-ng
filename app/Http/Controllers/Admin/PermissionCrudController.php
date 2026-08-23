<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;
// VALIDATION
use App\Http\Requests\PermissionRequest as StoreRequest;
use App\Http\Requests\PermissionRequest as UpdateRequest;

class PermissionCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        $this->crud->setModel(config('laravel-permission.models.permission'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.permission_singular'), trans('backpack::permissionmanager.permission_plural'));
        $this->crud->setRoute(config('backpack.base.route_prefix').'/permission');

        $this->crud->addColumn([
            'name'  => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type'  => 'text',
        ]);

        $this->crud->addColumn([ // n-n relationship (with pivot table)
            'label'     => trans('backpack::permissionmanager.roles_have_permission'),
            'type'      => 'select_multiple',
            'name'      => 'roles',
            'entity'    => 'roles',
            'attribute' => 'name',
            'model'     => "Backpack\PermissionManager\app\Models\Role",
            'pivot'     => true,
        ]);

        $this->crud->addField([
            'name'  => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type'  => 'text',
        ]);

        $this->crud->addField([
            'label'     => trans('backpack::permissionmanager.roles'),
            'type'      => 'checklist',
            'name'      => 'roles',
            'entity'    => 'roles',
            'attribute' => 'name',
            'model'     => "Backpack\PermissionManager\app\Models\Role",
            'pivot'     => true,
        ]);

        if (!config('backpack.permissionmanager.allow_permission_create')) {
            $this->crud->denyAccess('create');
        }

        if (!config('backpack.permissionmanager.allow_permission_update')) {
            $this->crud->denyAccess('update');
        }

        if (!config('backpack.permissionmanager.allow_permission_delete')) {
            $this->crud->denyAccess('delete');
        }
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}
