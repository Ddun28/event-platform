<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $events = Event::with(['user', 'categories', 'tags', 'participants'])
            ->filter(request()->query())
            ->paginate(15);

        return EventResource::collection($events);
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        $event = auth()->user()->events()->create($request->validated());
        
        $event->categories()->sync($request->categories);
        $event->tags()->sync($request->tags);

        return response()->json([
            'message' => 'Evento creado exitosamente',
            'data' => new EventResource($event->loadMissing(['user', 'categories', 'tags']))
        ], 201);
    }

    public function show(Event $event): JsonResponse
    {
        $event->load(['user', 'categories', 'tags', 'participants']);
        return response()->json(new EventResource($event));
    }

    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        $this->authorize('update', $event);
        
        $event->update($request->validated());
        
        if ($request->has('categories')) {
            $event->categories()->sync($request->categories);
        }
        
        if ($request->has('tags')) {
            $event->tags()->sync($request->tags);
        }

        return response()->json([
            'message' => 'Evento actualizado exitosamente',
            'data' => new EventResource($event->fresh(['user', 'categories', 'tags']))
        ]);
    }

    public function destroy(Event $event): JsonResponse
    {
        $this->authorize('delete', $event);
        
        $event->delete();
        
        return response()->json([
            'message' => 'Evento eliminado exitosamente'
        ]);
    }

    public function register(Event $event): JsonResponse
    {
        abort_if($event->end_date < now(), 400, 'El evento ya ha finalizado');
        
        auth()->user()->events()->syncWithoutDetaching($event->id);
        
        return response()->json([
            'message' => 'Inscripción exitosa',
            'qr_code' => $this->generateQrCode($event)
        ]);
    }

    protected function generateQrCode(Event $event): string
    {
        return md5(auth()->id() . $event->id . now()->timestamp);
    }
}