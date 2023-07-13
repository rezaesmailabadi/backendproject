<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
    public function rules():array
        {
            if($this->isMethod('post')){
                return [
                    'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                    'description' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
                    'image' => 'required',
                    'status' => 'required|numeric|in:0,1',
                    'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                ];
            }
            else{
                return [
                    'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                    'description' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
                    'image' => 'required',
                    'status' => 'required|numeric|in:0,1',
                    'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                ];
            }
    }

    public function messages(){
        if(request()->isMethod('post')){
            return [
                'name.required' => 'name is required!',
                'description.required' => 'description is required!',
                'image.required' => 'image is required!',
                'status.required' => 'status is required!',
                'tags.required' => 'tags is required!',
            ];
        }
        else{
            return [
                'name.required' => 'name is required!',
                'description.required' => 'description is required!',
                'image.required' => 'image is required!',
                'status.required' => 'status is required!',
                'tags.required' => 'tags is required!',
            ];
        }


    }
}
