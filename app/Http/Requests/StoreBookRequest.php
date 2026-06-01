<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'type' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books',
            'publish_year' => 'nullable|integer',
            'shelf_location' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'file_ebook' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }
}
