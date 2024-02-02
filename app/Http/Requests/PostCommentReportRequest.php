<?php

namespace App\Http\Requests;

use App\Enums\ReportsType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostCommentReportRequest extends FormRequest
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
        if($this->method() == 'POST'){
            return [
                'message' => [
                    'max:255',
                    'required',
                    'string'
                ],
                'comment_id' => [
                    'required',
                    'exists:post_comments,id',
                    'integer'
                ],
            ];
        }else {
            return [
                'status' => [
                    Rule::enum(ReportsType::class),
                    'required'
                ]
            ];
        }
    }
}
