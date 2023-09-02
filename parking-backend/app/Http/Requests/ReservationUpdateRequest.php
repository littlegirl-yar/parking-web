<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route()->reservation);
    }

    public function rules(): array
    {
        return [
            'start' => ['required', 'date', 'after_or_equal:now'],
            'end'   => ['required', 'date', 'after:start'],
        ];
    }
    public function bodyParameters()
    {
        return [
            'start' => [
                'description' => 'Start date for spot reservation',
                'example' => '2022-12-15 00:35:00',
            ],
            'end' => [
                'description' => 'End date for spot reservation',
                'example' => '2022-12-15 01:50:00',
            ],
        ];
    }
}
