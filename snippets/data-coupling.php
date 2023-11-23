<?php

namespace App\Models;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class StoreController
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function pay(Request $request): JsonResponse
    {
        $cartId = new CartId($request->get('cart_id'));
        $paymentMethod = new Payment(
            $request->get('payment_method'),
            $this->paymentService->calculate()
        );

        $this->paymentService->pay($cartId, $paymentMethod);

        return new JsonResponse(['message' => 'Payment successful'], 200);
    }
}

