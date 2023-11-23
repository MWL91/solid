<?php

namespace App\Http\Requests;

use App\Services\OrdersService;
use App\ValueObjects\Payment;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return array_key_exists($this->get('payment_method'), OrdersService::PAYMENT_METHODS);
    }
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'price' => ['required', 'numeric'],
            'currency' => ['required', 'string', 'in:PLN,EUR,USD'],
        ];
    }

    public function getPayment(): Payment
    {
        return new Payment(
            $this->get('order_id'),
            $this->get('price'),
            $this->get('currency')
        );
    }
}
