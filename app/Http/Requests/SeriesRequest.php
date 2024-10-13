<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       
        return [
            'title' => 'required|string|max:255', 
            'author_name' => 'required',  
            'description' => 'nullable|string|max:1000', 
            'status' => 'required|in:ongoing,completed,onHiatus',
            'thumbnail' => 'nullable|string',
            'characters' => 'required|array',
            'characters.*.cname' => 'required|string|max:255', 
            'characters.*.summary' => 'nullable|string|max:1000', 
            'characters.*.role' => 'nullable|string|in:main,antagonist,supporting',
            'characters.*.image' => 'nullable|string',
        ];
    }


     public function messages()
     {
        // dd("here 111");
         return [
             'title.required' => 'The webtoon title is required.',
             'status.required' => 'The status of the webtoon is required.',
             'characters.*.cname.required' => 'The character name is required.',
             'characters.*.summary.max' => 'The description must not exceed 1000 characters.',
             'characters.*.role.in' => 'The role must be either main, antagonist, or supporting.'
         ];
     }
}
