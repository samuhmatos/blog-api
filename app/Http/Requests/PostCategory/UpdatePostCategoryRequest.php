<?php

namespace App\Http\Requests\PostCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('is_admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'max:50',
                Rule::unique('post_categories')
                    ->ignore($this->route('postCategory')->id)
            ],
            'slug' => [
                'string',
                'max:255',
                Rule::unique('post_categories')
                    ->ignore($this->route('postCategory')->id)
            ],
            'description' => ['string', 'max:255']
        ];
    }
}
