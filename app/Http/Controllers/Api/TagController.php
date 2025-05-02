<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TagResource::collection(
            Tag::filter(request()->query())
                ->paginate(25)
        );
    }

    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = Tag::create($request->validated());
        
        return response()->json([
            'message' => 'Etiqueta creada exitosamente',
            'data' => new TagResource($tag)
        ], 201);
    }

    public function show(Tag $tag): JsonResponse
    {
        return response()->json(new TagResource($tag));
    }

    public function update(UpdateTagRequest $request, Tag $tag): JsonResponse
    {
        $tag->update($request->validated());
        
        return response()->json([
            'message' => 'Etiqueta actualizada exitosamente',
            'data' => new TagResource($tag->fresh())
        ]);
    }

    public function destroy(Tag $tag): JsonResponse
    {
        $tag->delete();
        
        return response()->json([
            'message' => 'Etiqueta eliminada exitosamente'
        ]);
    }
}