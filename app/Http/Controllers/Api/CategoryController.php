<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $categories = Category::all();
        return $this->success(CategoryResource::collection($categories), 'Categories retrieved successfully');
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return $this->success(new CategoryResource($category), 'Category created successfully', 201);
    }

    public function show(Category $category)
    {
        return $this->success(new CategoryResource($category), 'Category retrieved successfully');
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return $this->success(new CategoryResource($category), 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->success(null, 'Category deleted successfully');
    }
}
