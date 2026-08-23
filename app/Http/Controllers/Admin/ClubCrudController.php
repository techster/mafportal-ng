<?php

namespace App\Http\Controllers\Admin;

use App\Models\Club;
use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ClubRequest as StoreRequest;
use App\Http\Requests\ClubRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ClubCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Club");
        $this->crud->setRoute("admin/club");
        $this->crud->setEntityNameStrings('club', 'clubs');
    }

    public function setUp()
    {
        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        // Фильтр для админов клуба
        if( !Auth::user()->hasAnyRole(['Technical Admin','Portal Admin']) ){
            $this->crud->addClause('join', 'club_user', function ($query) {
                $query->on('clubs.id', '=', 'club_user.club_id')
                    ->where('club_user.user_id', '=', Auth::user()->id)
                    ->where('club_user.admin', '=', 1);
            });
        }

        // Eng
        $this->crud->addField([
            'name' => 'title',
            'label' => "Title",
            'type' => 'text',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => "Slug",
            'type' => 'text',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'city',
            'label' => "City",
            'type' => 'text',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label' => "Countries",
            'type' => 'select',
            'name' => 'country_id',
            'entity' => 'country',
            'attribute' => 'title',
            'tab' => 'Eng',
            'model' => "App\Models\Country",
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'label'      => 'Admins',
            'type'       => 'select2_multiple_pivot',
            'name'       => 'users_admin',
            'entity'     => 'users_admin',
            'attribute'  => 'name',
            'attribute2' => 'last_name',
            'attribute3' => 'nickname',
            'model'      => "App\User",
            'pivot'      => false,
            'tab'        => 'Eng',
        ]);

        $this->crud->addField([
            'label' => 'Rating table',
            'type' => 'select',
            'name' => 'table_ratings_id',
            'entity' => 'table_ratings',
            'attribute' => 'title',
            'model' => "App\Models\Table_rating",
            'tab' => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'private',
            'label' => 'Private club?',
            'type' => 'checkbox',
            'tab' => 'Eng',
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

        $this->crud->addField([
            'name' => 'text',
            'label' => 'About the club',
            'type' => 'ckeditor',
            'tab' => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'meta_title',
            'label' => 'Meta Title',
            'type' => 'text',
            'tab'   => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'meta_description',
            'label' => 'Meta Description',
            'type' => 'text',
            'tab'   => 'Eng',
        ]);


        // Rus
        $this->crud->addField([
            'name' => 'text_ru',
            'label' => 'About the club (Russian)',
            'type' => 'ckeditor',
            'tab' => 'Rus',
        ]);

        $this->crud->addField([
            'name' => 'meta_title_ru',
            'label' => 'Meta Title',
            'type' => 'text',
            'tab'   => 'Rus',
        ]);

        $this->crud->addField([
            'name' => 'meta_description_ru',
            'label' => 'Meta description',
            'type' => 'text',
            'tab'   => 'Rus',
        ]);

        // CRUD COLUMNS
        $this->crud->addColumn('title');
        $this->crud->addColumn('city');
        $this->crud->addColumn([
            'name' => 'private',
            'label' => 'Private club',
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
        $club_id = Route::current()->parameters()['club'];

        foreach (Club::find($club_id)->users_admin as $key => $item) {
            Club::find($club_id)->users()->updateExistingPivot($item->id, ['admin' => 0]);
        }

        if(is_array($request->input('users_admin'))){
            foreach ($request->input('users_admin') as $key => $item) {
                Club::find($club_id)->users()->updateExistingPivot($item, ['admin' => 1]);
            }
        }

        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
