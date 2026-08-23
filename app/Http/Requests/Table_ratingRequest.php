<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Table_ratingRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'title' => 'unique:table_ratings,title,'.\Request::get('id').'|required|min:3|max:255',
             'best_player' => 'required|min:1',
             'best_step' => 'required|min:1',
             'win_citizen' => 'required|min:1',
             'win_sheriff' => 'required|min:1',
             'win_mafia' => 'required|min:1',
             'win_don' => 'required|min:1',
             'fail_citizen' => 'required|min:1',
             'fail_sheriff' => 'required|min:1',
             'fail_mafia' => 'required|min:1',
             'fail_don' => 'required|min:1',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
