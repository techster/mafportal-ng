<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\CrudPanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Form as Form;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Backpack\CRUD\app\Http\Controllers\CrudFeatures\Reorder;
use Backpack\CRUD\app\Http\Controllers\CrudFeatures\AjaxTable;
// CRUD Traits for non-core features
use Backpack\CRUD\app\Http\Controllers\CrudFeatures\Revisions;
use Backpack\CRUD\app\Http\Controllers\CrudFeatures\SaveActions;
use Backpack\CRUD\app\Http\Requests\CrudRequest as StoreRequest;
use Backpack\CRUD\app\Http\Requests\CrudRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudFeatures\ShowDetailsRow;

class CrudController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    use AjaxTable, Reorder, Revisions, ShowDetailsRow, SaveActions;

    public $data = [];
    public $crud;
    public $request;

    public function __construct()
    {

        if (! $this->crud) {
            $this->crud = app()->make(CrudPanel::class);
            // call the setup function inside this closure to also have the request there
            // this way, developers can use things stored in session (auth variables, etc)
            $this->middleware(function ($request, $next) {
                $this->request = $request;
                $this->crud->request = $request;
                $this->setup();

                return $next($request);
            });


        }
    }

    /**
     * Allow developers to set their configuration options for a CrudPanel.
     */
    public function setup()
    {

    }

    /**
     * Display all rows in the database for this entity.
     *
     * @return Response
     */
    public function index()
    {
        $this->crud->hasAccessOrFail('list');

        $this->data['crud'] = $this->crud;
        $this->data['title'] = ucfirst($this->crud->entity_name_plural);

        // get all entries if AJAX is not enabled
        if (! $this->data['crud']->ajaxTable()) {

            $this->data['entries'] = $this->data['crud']->getEntries();

        }

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getListView(), $this->data);
    }

    /**
     * Show the form for creating inserting a new row.
     *
     * @return Response
     */
    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = trans('backpack::crud.add').' '.$this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getCreateView(), $this->data);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @param StoreRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCrud(StoreRequest $request = null)
    {
        $this->crud->hasAccessOrFail('create');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ($request->input() as $key => $value) {
            if (empty($value) && $value !== '0') {
                $request->request->set($key, null);
            }
        }

        // insert item in the db
        $item = $this->crud->create($request->except(['save_action', '_token', '_method']));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');

        // Проверка разрешения редактировать конкретную запись
        if($this->crud->entity_name == "club"){
            if(
                Auth::user()->hasAnyRole(['Technical Admin','Portal Admin'])
                or $this->crud->getEntry($id)->users_admin->contains(Auth::user()->id)
            ) {
                // OK
            } else {
                abort(404);
            }
        }

        if( in_array($this->crud->entity_name, array("photo gallery", "video gallery", "game rating", "table rating")) ){
            if(
                Auth::user()->hasAnyRole(['Technical Admin','Portal Admin'])
                or Auth::user()->clubs_admin->contains($this->crud->getEntry($id)->club_id)
            ) {
                // OK
            } else {
                abort(404);
            }
        }

        if( in_array($this->crud->entity_name, array("event", "User")) ){
            if(
                Auth::user()->hasAnyRole(['Technical Admin','Portal Admin'])
                or count(Auth::user()->clubs_admin->intersect($this->crud->getEntry($id)->clubs))
            ) {
                // OK
            } else {
                abort(404);
            }
        }

        // Добавляем дополнительные поля в Игры от Таблицы рейтинга
        $this->extra_fields($id);

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;

        $this->data['id'] = $id;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getEditView(), $this->data);
    }

    /**
     * Update the specified resource in the database.
     *
     * @param UpdateRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCrud(UpdateRequest $request = null)
    {
        $this->crud->hasAccessOrFail('update');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ($request->input() as $key => $value) {
            if (empty($value) && $value !== '0') {
                $request->request->set($key, null);
            }
        }

        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
                            $request->except('save_action', '_token', '_method'));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = trans('backpack::crud.preview').' '.$this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getShowView(), $this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return string
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        return $this->crud->delete($id);
    }

    // Добавляем дополнительные поля в Игры от Таблицы рейтинга
    public function extra_fields($id)
    {
	    $uri = Config::get('app.locale')."/api/user";

        if( in_array($this->crud->entity_name, array("game rating")) && (isset(\App\Models\Game_rating::find($id)->tournament->table_ratings) || isset(\App\Models\Game_rating::find($id)->club->table_ratings)) ){
            if(isset(\App\Models\Game_rating::find($id)->club->table_ratings)) $parent = "club";
            if(isset(\App\Models\Game_rating::find($id)->tournament->table_ratings)) $parent = "tournament";

            $table_ratings = \App\Models\Game_rating::find($id)[$parent]->table_ratings;
            if( isset($table_ratings->extra_field) && $table_ratings->extra_field ){
                foreach ($table_ratings->extra_field as $key => $item) {
                    if( !isset($item->id) || !$item->id ) continue;
                    if( !isset($item->name) || !$item->name ) continue;
                    if( !isset($item->type) || !$item->type ) continue;

                    $item_id = str_replace("#", "", $item->id);

                    if($item->type == "checkbox"){
                        $this->crud->addField([
                            'name' => "extra_".$item_id,
                            'label' => $item->name,
                            'type' => 'checkbox',
                            'fake' => true,
                            'store_in' => 'extra_field'
                        ]);
                    } else {
                        $this->crud->addField([
                            'name' => "extra_".$item_id,
                            'label' => $item->name,
                            'type' => "select2_from_ajax",
                            'entity' => 'user',
                            'attribute' => "last_name",
                            'attribute2' => "name",
                            'attribute3' => "nickname",
                            'model' => "App\User",
                            'data_source' => url($uri),
                            'placeholder' => "Select player",
                            'minimum_input_length' => 1,
                            'fake' => true,
                            'store_in' => 'extra_field'
                        ]);
                    }
                }
            }
        }
    }

}
