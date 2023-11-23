<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\ValueObjects\Payment;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'price' => ['required', 'min:0'],
            'currency' => ['required'],
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
