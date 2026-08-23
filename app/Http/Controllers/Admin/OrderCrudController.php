<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\OrderRequest as StoreRequest;
use App\Http\Requests\OrderRequest as UpdateRequest;

class OrderCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Order');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/order');
        $this->crud->setEntityNameStrings('order', 'orders');
    }

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->addField([
            'label' => "User",
            'type' => 'select',
            'name' => 'user_id',
            'entity' => 'user',
            'attribute' => 'name',
            'attribute2' => 'last_name',
            'attribute3' => 'nickname',
            'model' => "App\User",
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'created_at',
            'label' => 'Date',
            'type' => 'datetime_picker',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        // Cart
        $this->crud->addFields([
            [
                'name' => 'cart_items',
                'label' => 'Cart',
                'type' => 'table',
                'fake' => true,
                'store_in' => 'cart',
                'entity_singular' => 'item',
                'columns' => [
                    'id' => 'ID',
                    'name' => 'Name',
                    'qty' => 'Qty',
                    'price' => 'Price'
                ],
            ],
            [
                'name'  => 'total',
                'label' => "Total sum",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'cart',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'pay',
                'label' => "Order has been paid?",
                'type' => 'select_from_array',
                'options' => [
                    "0" => "No",
                    "1" => "Yes"
                ],
                'allows_null' => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
        ]);

        // Shipping
        $this->crud->addFields([
            [   // CustomHTML
                'name' => 'separator',
                'type' => 'custom_html',
                'value' => '<strong>Shipping address</strong>',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ]
            ],
            [
                'name'        => 'shipping_title',
                'label'       => 'Title',
                'type'        => 'radio',
                'fake'        => true,
                'store_in'    => 'payment_data',
                'options'     => [
                    'MRS.' => 'MRS.',
                    'MS.' => 'MS.',
                    'MR.' => 'MR.',
                ],
                'inline' => true,
            ],
            [
                'name'  => 'shipping_name',
                'label' => "Name",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'shipping_address1',
                'label' => "Address line 1",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'shipping_address2',
                'label' => "Address line 2",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'shipping_city',
                'label' => "City",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'shipping_region',
                'label' => "Region",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'shipping_zip',
                'label' => "ZIP",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'shipping_country',
                'label' => "Country",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'shipping_email',
                'label' => "Email",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ]
        ]);

        // Columns
        $this->crud->addColumn([
            'name' => 'id',
            'label' => "№"
        ]);

        $this->crud->addColumn([
            'label' => "User",
            'type' => 'select',
            'name' => 'user_id',
            'entity' => 'user',
            'attribute' => 'name',
            'attribute2' => 'last_name',
            'attribute3' => 'nickname',
            'model' => "App\User",
        ]);

        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => "Date"
        ]);

        $this->crud->addColumn([
            'name' => 'pay', // The db column name
            'label' => "Pay", // Table column heading
            'type' => 'check'
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
