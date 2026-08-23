<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GlobalRatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = \Request::get('id');
        return [
            'rating_title' => 'required|min:2|max:255|unique:global_ratings,rating_title'.($id ? ','.$id : ''),
            'rating_title_ru' => 'required|min:2|max:255',
            'sub_heading' => 'required|min:2|max:255',
            'sub_heading_ru' => 'required|min:2|max:255',
            'from_date' => 'required',
            'to_date' => 'required'
        ];
    }
}
