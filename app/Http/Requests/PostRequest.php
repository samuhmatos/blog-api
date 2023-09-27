<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'=> [
                'required',
                'string',
                'max:120',
            ],
            'sub_title'=> ['required','string', 'max:200'],
            'content'=> ['required','string'],
            'banner'=> [
                Rule::requiredIf($this->method() === "POST"),
                'image',
                'max:500000'
            ],
            'category_id'=> ['required','integer', 'exists:post_categories,id'],
            'is_draft'=>['required','boolean']
        ];
    }
}
