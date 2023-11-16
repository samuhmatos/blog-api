<?php

namespace App\Http\Requests\PostComment;

use App\Models\PostComment;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()
            ->can(
                'owner',
                [
                    PostComment::class,
                    $this->route('postComment'),
                ]
            );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'comment'=> ['required', 'string', 'max:250']
        ];
    }
}
