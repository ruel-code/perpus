<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Book::with('category');

        $query->when($request->title, function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->title . '%');
        });

        $query->when($request->author, function ($q) use ($request) {
            $q->where('author', 'like', '%' . $request->author . '%');
        });

        $query->when($request->category_id, function ($q) use ($request) {
            $q->where('category_id', $request->category_id);
        });

        $books = $query->get();
        return $this->success(BookResource::collection($books), 'Books retrieved successfully');
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();
        $data['available_stock'] = $data['stock'];
        $book = Book::create($data);
        return $this->success(new BookResource($book), 'Book created successfully', 201);
    }

    public function show(Book $book)
    {
        return $this->success(new BookResource($book->load('category')), 'Book retrieved successfully');
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return $this->success(new BookResource($book), 'Book updated successfully');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return $this->success(null, 'Book deleted successfully');
    }
}
