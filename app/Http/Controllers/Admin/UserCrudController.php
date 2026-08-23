<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Models\Club;
use App\User;
use App\Http\Controllers\Admin\CrudController;
use App\Http\Requests\UserRequest as StoreRequest;
// VALIDATION
use App\Http\Requests\UserRequest as UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        $this->crud->setModel(config('backpack.permissionmanager.user_model'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(config('backpack.base.route_prefix').'/user');
//        $this->crud->enableAjaxTable();
    }

    public function setUp()
    {
        // Фильтр для админов клуба
        if( !Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']) ) {
            $club_ids = Auth::user()->clubs_admin->pluck('id')->toArray();

            $this->crud->addClause('whereHas', 'clubs', function ($query) use ($club_ids) {
                $query->whereIn('id', $club_ids);
            });
        }

        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => trans('account.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'last_name',
                'label' => trans('account.last_name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'nickname',
                'label' => "Nickname",
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('account.email'),
                'type'  => 'email',
            ],
            [
                'label'     => "Clubs",
                'type'      => 'select_multiple',
                'name'      => 'clubs',
                'entity'    => 'clubs',
                'attribute' => 'title',
                'model'     => "App\Models\Club",
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'roles', // the method that defines the relationship in your Model
                'entity'    => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => "Backpack\PermissionManager\app\Models\Roles", // foreign key model
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'permissions', // the method that defines the relationship in your Model
                'entity'    => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => "Backpack\PermissionManager\app\Models\Permission", // foreign key model
            ],
            [
                'name'  => 'balance',
                'label' => trans('account.balance'),
                'type'  => 'text',
            ],
            [
                'name'  => 'created_at',
                'label' => trans('account.created_at'),
                'type'  => 'text',
            ],
        ]);

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => trans('account.name'),
                'type'  => 'text',
                'tab' => 'Main',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'last_name',
                'label' => trans('account.last_name'),
                'type'  => 'text',
                'tab' => 'Main',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'nickname',
                'label' => "Nickname",
                'type'  => 'text',
                'tab' => 'Main',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
                'tab' => 'Main',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type'  => 'password',
                'tab' => 'Main',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
                'tab' => 'Main',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'label'     => 'Clubs',
                'type'      => 'select2_multiple',
                'name'      => 'clubs',
                'entity'    => 'clubs',
                'attribute' => 'title',
                'model'     => "App\Models\Club",
                'pivot'     => true,
                'tab' => 'Main',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ]
            ],
//            [
//                'label' => 'Active player?',
//                'name' => 'active',
//                'type' => 'checkbox'
//            ],
            [
                // two interconnected entities
                'label'             => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type'              => 'checklist_dependency',
                'name'              => 'roles_and_permissions', // the methods that defines the relationship in your Model
                'tab' => 'Main',
                'subfields'         => [
                    'primary' => [
                        'label'            => trans('backpack::permissionmanager.roles'),
                        'name'             => 'roles', // the method that defines the relationship in your Model
                        'entity'           => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute'        => 'name', // foreign key attribute that is shown to user
                        'model'            => "Backpack\PermissionManager\app\Models\Role", // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'name', // foreign key attribute that is shown to user
                        'model'          => "Backpack\PermissionManager\app\Models\Permission", // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],
        ]);



        // Shipping
        $this->crud->addFields([
            [   // CustomHTML
                'name' => 'separator',
                'type' => 'custom_html',
                'tab' => 'Payment data',
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
                'tab'         => 'Payment data',
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
                'tab' => 'Payment data',
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
                'tab' => 'Payment data',
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
                'tab' => 'Payment data',
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
                'tab' => 'Payment data',
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
                'tab' => 'Payment data',
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
                'tab' => 'Payment data',
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
                'tab' => 'Payment data',
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
                'tab' => 'Payment data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ]
        ]);

        // Billing
        $this->crud->addFields([
            [   // CustomHTML
                'name' => 'separator2',
                'type' => 'custom_html',
                'tab' => 'Payment data',
                'value' => '<br><strong>Billing address</strong>',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ]
            ],
            [
                'name'        => 'billing_title',
                'label'       => 'Title',
                'type'        => 'radio',
                'fake'        => true,
                'store_in'    => 'payment_data',
                'tab'         => 'Payment data',
                'options'     => [
                    'MRS.' => 'MRS.',
                    'MS.' => 'MS.',
                    'MR.' => 'MR.',
                ],
                'inline' => true,
            ],
            [
                'name'  => 'billing_name',
                'label' => "Name",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'tab' => 'Payment data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'billing_address1',
                'label' => "Address line 1",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'tab' => 'Payment data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'billing_address2',
                'label' => "Address line 2",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'tab' => 'Payment data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'billing_city',
                'label' => "City",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'tab' => 'Payment data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'billing_region',
                'label' => "Region",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'tab' => 'Payment data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'billing_zip',
                'label' => "ZIP",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'tab' => 'Payment data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'billing_country',
                'label' => "Country",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'tab' => 'Payment data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name'  => 'billing_email',
                'label' => "Email",
                'type'  => 'text',
                'fake' => true,
                'store_in' => 'payment_data',
                'tab' => 'Payment data',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]
            ]
        ]);

        // we want to hide delete button
        $this->crud->removeButton('delete');


    }

    /**
     * Store a newly created resource in the database.
     *
     * @param StoreRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $this->crud->hasAccessOrFail('create');

        // insert item in the db
        if ($request->input('password')) {
            $item = $this->crud->create(\Request::except(['redirect_after_save']));

            // now bcrypt the password
            $item->password = bcrypt($request->input('password'));
            $item->save();
        } else {
            $item = $this->crud->create(\Request::except(['redirect_after_save', 'password']));
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }

    public function update(UpdateRequest $request)
    {
        //encrypt password and set it to request
        $this->crud->hasAccessOrFail('update');

        $dataToUpdate = \Request::except(['redirect_after_save', 'password']);

        //encrypt password
        if ($request->input('password')) {
            $dataToUpdate['password'] = bcrypt($request->input('password'));
        }

        // update the row in the db
        $this->crud->update(\Request::get($this->crud->model->getKeyName()), $dataToUpdate);

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction();
    }

    public function api_index(Request $request)
    {
        $search_term = $request->input('q');
        $page = $request->input('page');

        if ($search_term)
        {
            $results = User::where('last_name', 'LIKE', '%'.$search_term.'%')
                ->orwhere('name', 'LIKE', '%'.$search_term.'%')
                ->orwhere('nickname', 'LIKE', '%'.$search_term.'%')
                ->paginate(10);
        }
        else
        {
            $results = User::paginate(10);
        }

        return $results;
    }

    public function api_show($id)
    {
        return User::find($id);
    }

    public function confirm_user_to_club($club_id, $user_id)
    {
        Club::find($club_id)->users()->updateExistingPivot($user_id, ['confirm' => 1]);
        return redirect()->back();
    }
    public function cancel_user_to_club($club_id, $user_id)
    {
        Club::find($club_id)->users()->detach($user_id);
        return redirect()->back();
    }
}
