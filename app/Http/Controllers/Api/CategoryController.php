<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            Category::filter(request()->query())
                ->paginate(25)
        );
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());
        
        return response()->json([
            'message' => 'Categoría creada exitosamente',
            'data' => new CategoryResource($category)
        ], 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json(new CategoryResource($category));
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());
        
        return response()->json([
            'message' => 'Categoría actualizada exitosamente',
            'data' => new CategoryResource($category->fresh())
        ]);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        
        return response()->json([
            'message' => 'Categoría eliminada exitosamente'
        ]);
    }
}