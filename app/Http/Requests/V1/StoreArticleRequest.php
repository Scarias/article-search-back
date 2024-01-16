<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            'title' => 'required|max:250',
            'content' => 'required',
            'user_id' => 'required',
        ];
    }

    /**
     * Add fields required to create the desired resource/collection.
     */
    protected function prepareForValidation()
    {
        $to_merge = [];
        if (isset($this->createdBy)) $to_merge['user_id'] = $this->createdBy;

        $this->merge($to_merge);
    }
}
