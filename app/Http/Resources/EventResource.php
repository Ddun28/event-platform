<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
{
    return [
        'id' => $this->id,
        'title' => $this->title,
        'description' => $this->description,
        'dates' => [
            'start' => $this->start_date->toIso8601String(),
            'end' => $this->end_date->toIso8601String()
        ],
        'location' => $this->location,
        'organizer' => $this->user->name,
        'categories' => CategoryResource::collection($this->categories),
        'tags' => TagResource::collection($this->tags),
        'participants_count' => $this->participants_count,
        'links' => [
            'self' => route('api.events.show', $this),
            'register' => route('api.events.register', $this)
        ]
    ];
}
}
