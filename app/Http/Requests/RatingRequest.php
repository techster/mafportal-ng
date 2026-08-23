<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RatingRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
             'club' => 'required|min:3|max:255',
             'player' => 'required|min:1',
             'game' => 'required|min:1',
             'citizen' => 'required|min:1',
             'mafia' => 'required|min:1',
             'sheriff' => 'required|min:1',
             'don' => 'required|min:1',
             'bm' => 'required|min:1',
             'bp' => 'required|min:1',
             'balls' => 'required|min:1',
             'score' => 'required|min:1',
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
