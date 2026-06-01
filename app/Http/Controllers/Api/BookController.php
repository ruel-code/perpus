<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    use ApiResponse;

    private function handleCoverImage($request, $book = null)
    {
        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('covers', 'public');
            return Storage::url($path);
        }

        if ($request->filled('cover_image') && !$request->hasFile('cover_file')) {
            return $request->cover_image;
        }

        return $book ? $book->cover_image : null;
    }

    private function handleEbookFile($request, $book = null)
    {
        if ($request->hasFile('file_ebook')) {
            $path = $request->file('file_ebook')->store('ebooks', 'public');
            return Storage::url($path);
        }

        return $book ? $book->file_ebook : null;
    }

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
        $data['cover_image'] = $this->handleCoverImage($request);
        $data['file_ebook'] = $this->handleEbookFile($request);
        $book = Book::create($data);
        return $this->success(new BookResource($book), 'Book created successfully', 201);
    }

    public function show(Book $book)
    {
        return $this->success(new BookResource($book->load('category')), 'Book retrieved successfully');
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $data = $request->validated();
        $data['cover_image'] = $this->handleCoverImage($request, $book);
        $data['file_ebook'] = $this->handleEbookFile($request, $book);
        $book->update($data);
        return $this->success(new BookResource($book), 'Book updated successfully');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return $this->success(null, 'Book deleted successfully');
    }

    public function ebook(Book $book)
    {
        if (!$book->file_ebook) {
            return $this->error('No e-book file available for this book', 404);
        }

        $relativePath = str_replace('/storage/', '', $book->file_ebook);

        if (!Storage::disk('public')->exists($relativePath)) {
            return $this->error('E-book file not found on server', 404);
        }

        $filePath = Storage::disk('public')->path($relativePath);
        $filename = \Illuminate\Support\Str::slug($book->title) . '.pdf';

        $request = request();

        if ($request->download) {
            return response()->download($filePath, $filename);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}
