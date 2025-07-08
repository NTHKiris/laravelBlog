<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'name'=> 'required|string|max:255|min:3',
            'type' => 'required|in:novel,manga,science,news,document',
            'price' => 'required|integer|min:1000|max:1000000000000',
            'description' => 'nullable|string|max:1000',
            'author_id' => 'nullable|exists:authors,id'
        ];
    }
    public function messages():array {
        return [
        'name.required' => 'Tên sách là bắt buộc.',
        'name.min'=>'Phải có ít nhất 3 kí tự',
        'name.max'=>'Tên sách không được quá 255 kí tự',
        ];
    }

    public function attributes(): array
    {
        return [
            // 'name' => 'tên sách',
            // 'type' => 'loại sách', 
            // 'price' => 'giá sách', 
            // 'description' => 'mô tả',
            // 'author_id' => 'tác giả'
        ];
    }
}
