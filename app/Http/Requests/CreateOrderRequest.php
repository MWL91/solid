<?php

namespace App\Http\Requests;

use App\ValueObjects\CreateNewOrder;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'price' => ['required', 'numeric'],
            'currency' => ['required', 'string', 'in:PLN,EUR,USD'],
        ];
    }

    public function getId(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function getOrder(): CreateNewOrder
    {
        return new CreateNewOrder(
            $this->get('price'),
            $this->get('currency'),
            false,
            null,
        );
    }
}
