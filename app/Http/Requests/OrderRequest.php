<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        
        if ($this->isMethod('post')) {
          
            return [
                'title' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'introduction' => 'required|max:1000|min:5',
                
                'price' => 'required|numeric',
                'image' => 'required',
                'status' => 'required|numeric|in:0,1',
                'publishable' => 'required|numeric|in:0,1',
                'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'category_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:categories,id',
                'user_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:users,id',
                
                // 'published_at' => 'required',
                // 'first_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                // 'last_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                // 'mobile' => 'required',
                // 'email' => 'required',


            ];
            
        } else {
           
            return
             [
                'title' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'introduction' => 'required|max:1000|min:5',
                
                'price' => 'required|numeric',
                'image' => 'required',
                'status' => 'required|numeric|in:0,1',
                'publishable' => 'required|numeric|in:0,1',
                'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'category_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:categories,id',
                
                // 'published_at' => 'required',
                // 'first_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                // 'last_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                // 'mobile' => 'required',
                // 'email' => 'required',
             ];
            }
        }
    
   
    public function messages(){
        if(request()->isMethod('post')){
            return [
                'title.required' => 'title.required!',
                'introduction.required' => 'introduction.required!',
                
                'price.required' => 'price.required!',
                'image.required' => 'image.required!',
                'status.required' => 'status.required!',
                'publishable.required' => 'publishable.required!',
                'tags.required' => 'tags.required!',
                'category_id.required' => 'category_id.required!',
                
                'published_at.required' => 'published_at.required!',
                'first_name.required' => 'first_name.required!',
                'lastname.required' => 'last_name.required!',
                'mobile.required' => 'mobile.required!',
                'email.required' => 'email.required!',
                
            ];
        }
        else{
            return [
                'title.required' => 'title.required!',
                'introduction.required' => 'introduction.required!',
                
                'price.required' => 'price.required!',
                'image.required' => 'image.required!',
                'status.required' => 'status.required!',
                'publishable.required' => 'publishable.required!',
                'tags.required' => 'tags.required!',
                'category_id.required' => 'category_id.required!',
                
                'published_at.required' => 'published_at.required!',
                'first_name.required' => 'first_name.required!',
                'lastname.required' => 'last_name.required!',
                'mobile.required' => 'mobile.required!',
                'email.required' => 'email.required!',
            ];
        }


    

    }
}