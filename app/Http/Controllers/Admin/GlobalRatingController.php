<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\GlobalRatingRequest as StoreRequest;
use App\Http\Requests\GlobalRatingRequest as UpdateRequest;

class GlobalRatingController extends CrudController {

    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("App\Models\GlobalRating");
        $this->crud->setRoute("admin/globalRatings");
        $this->crud->setEntityNameStrings('global rating', 'Global Ratings');
    }

    public function setUp() {
        //Eng
        $this->crud->addField([
            'name' => 'rating_title',
            'label' => "Title",
            'type' => 'text',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'sub_heading',
            'label' => "Sub Heading",
            'type' => 'text',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([ // image
            'label' => "Banner Image",
            'name' => "image",
            'type' => 'image',
            'upload' => true,
            'tab' => 'Eng',
            'crop' => true,
            'aspect_ratio' => 0,
            'default' => 'build/img/not_img.jpg',
            'disk' => 'uploads'
        ]);

        $this->crud->addField([
            'name' => 'from_date',
            'label' => 'From',
            'type' => 'date_picker',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'to_date',
            'label' => 'To',
            'type' => 'date_picker',
            'tab' => 'Eng',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'ckeditor',
            'tab' => 'Eng',
        ]);

        // Rus
        $this->crud->addField([
            'name' => 'rating_title_ru',
            'label' => "заглавие",
            'type' => 'text',
            'tab' => 'Rus',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'sub_heading_ru',
            'label' => "Подзаголовок",
            'type' => 'text',
            'tab' => 'Rus',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'description_ru',
            'label' => 'Описание',
            'type' => 'ckeditor',
            'tab' => 'Rus',
        ]);

        $this->crud->addColumn([
            'name' => 'rating_title',
            'label' => "Heading",
            'type' => 'Text',
        ]);

        $this->crud->addColumn([
            'name' => 'sub_heading',
            'label' => "Sub Heading",
            'type' => 'Text',
        ]);

        $this->crud->addColumn([
            'name' => 'from_date',
            'label' => "Start Date",
            'type' => 'date',
        ]);

        $this->crud->addColumn([
            'name' => 'to_date',
            'label' => "End Date",
            'type' => 'date',
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
