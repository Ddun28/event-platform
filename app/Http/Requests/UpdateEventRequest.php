<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'title' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'start_date' => 'sometimes|date|after:now',
        'end_date' => 'sometimes|date|after:start_date',
        'location' => 'sometimes|string|max:255',
        'categories' => 'sometimes|array|exists:categories,id',
        'tags' => 'sometimes|array|exists:tags,id'
    ];
}
}
