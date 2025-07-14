<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_name' => 'required|string|max:255',
            'status' => 'required|in:published,privated,draft'
        ];
        if ($this->has('thumpnail')) {
            $rules['thumpnail'] = 'nullable|url|max:2000';
        }

        return $rules;
    }
}
