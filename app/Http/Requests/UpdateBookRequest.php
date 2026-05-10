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
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'publisher' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|nullable|string|max:20|unique:books,isbn,' . $bookId,
            'stock' => 'sometimes|required|integer|min:0',
            'available_stock' => 'sometimes|required|integer|min:0',
            'description' => 'sometimes|nullable|string',
            'cover_image' => 'sometimes|nullable|string',
        ];
    }
}
