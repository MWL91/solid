<?php


namespace App\Models;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController
{
    public function receivePayment(Request $request): JsonResponse
    {
        $payment = Http::post('https://api.payments.com/pay', [
            'amount' => $request->get('amount'),
            'currency' => $request->get('currency'),
            'card_number' => $request->get('card_number'),
            'card_expiration_date' => $request->get('card_expiration_date'),
            'card_cvv' => $request->get('card_cvv'),
        ]);

        $payment = new Payment($payment->collect()->toArray());
        $payment->save();

        return $payment;
    }
}

