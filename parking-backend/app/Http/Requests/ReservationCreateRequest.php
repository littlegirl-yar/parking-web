<?php

namespace App\Http\Requests;

use App\Rules\ExistingReservationRuleForInterval;
use Illuminate\Foundation\Http\FormRequest;

class ReservationCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start'   => ['required', 'date', 'after_or_equal:now'],
            'end'     => ['required', 'date', 'after:start'],
            'spot_id' => ['required'],
            'range'   => [new ExistingReservationRuleForInterval($this->get('spot_id'))]
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'range' => [
                'start' => $this->get('start'),
                'end'   => $this->get('end')
            ]
        ]);
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
            'spot_id' => [
                'description' => 'The id of the spot',
                'example' => '11',
            ],
            'range' => [
                'description' => 'Validation rule',
            ],
        ];
    }
}
