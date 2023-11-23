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
        $validate = false;
        $isCart = false;

        if($request->boolean('withValidate')) {
            $validate = true;
        }

        if($request->has('cart_id')) {
            $isCart = true;
        }

        try {
            $this->paymentService->pay($request->all(), $validate, $isCart);
        } catch (\Exception) {
            return new JsonResponse(['message' => 'Payment failed'], 400);
        }

        return new JsonResponse(['message' => 'Payment successful'], 200);
    }
}

