<?php

namespace App\Services;

class Przelewy24Service
{

    private string $orderId;
    private float $price;
    private string $currency;

    /**
     * Przelewy24Service constructor.
     */
    public function __construct(string $orderId, float $price, string $currency)
    {
        $this->orderId = $orderId;
        $this->price = $price;
        $this->currency = $currency;
    }

    public function paymentUrl(): string
    {
        return 'https://sandbox.przelewy24.pl/trnRegister?price=' . $this->price * 100 . '&currency=' . $this->currency . '&orderId=' . $this->orderId;
    }
}
