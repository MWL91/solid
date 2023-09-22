<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CreateReservationAPIRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_name' => 'required',
            'office_id' => ['required', 'integer'],
            'reservation_date' => ['required', 'date'],
            'duration' => ['required', 'min:1']
        ];
    }
}
