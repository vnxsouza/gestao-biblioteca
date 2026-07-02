<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('book')->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'genre' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:quero_ler,lendo,lido'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5', 'required_if:status,lido'],
            'notes' => ['nullable', 'string'],
            'pages' => ['nullable', 'integer', 'min:1'],
        ];
    }
}