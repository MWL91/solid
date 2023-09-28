<?php

namespace App\Services;

class BlikService
{

    /**
     * BlikService constructor.
     */
    public function __construct()
    {
    }

    public function getHash(string $orderId, float $price): string
    {
        // this is example mock, that could be used in real app
        return md5($orderId . $price);
    }

    public function sendBlik(string $hash, string $code): bool
    {
        // mock for send blik
        // .. do nothing but send $hash + $code to blik service
        return true;
    }
}
