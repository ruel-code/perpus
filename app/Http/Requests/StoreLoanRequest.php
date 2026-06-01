<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Book;

class StoreLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => [
                'required',
                'exists:books,id',
                function ($attribute, $value, $fail) {
                    $book = Book::find($value);
                    if (!$book || $book->available_stock <= 0) {
                        $fail('Stok buku tidak mencukupi untuk dipinjam.');
                    }
                },
            ],
            'return_date' => 'required|date|after_or_equal:today',
            'processed_by' => 'nullable|exists:users,id',
            'condition_notes' => 'nullable|string',
        ];
    }
}
