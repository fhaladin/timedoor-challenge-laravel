<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image'    => 'mimes:jpeg,jpg,png,gif|max:1024',
            'name'     => 'nullable|string|min:3|max:16',
            'title'    => 'required|string|min:10|max:32',
            'body'     => 'required|string|min:10|max:200',
            'password' => 'nullable|numeric|digits:4'
        ];
    }
}
