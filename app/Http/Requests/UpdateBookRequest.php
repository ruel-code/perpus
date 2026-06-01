<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bookId = $this->route('book')->id;
        return [
            'category_id' => 'sometimes|required|exists:categories,id',
            'type' => 'sometimes|nullable|string|max:100',
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'publisher' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|nullable|string|max:20|unique:books,isbn,' . $bookId,
            'publish_year' => 'sometimes|nullable|integer',
            'shelf_location' => 'sometimes|nullable|string|max:100',
            'stock' => 'sometimes|required|integer|min:0',
            'available_stock' => 'sometimes|required|integer|min:0',
            'price' => 'sometimes|nullable|numeric|min:0',
            'description' => 'sometimes|nullable|string',
            'cover_image' => 'sometimes|nullable|string',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'file_ebook' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }
}
