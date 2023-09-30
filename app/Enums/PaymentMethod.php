<?php

namespace App\Enums;

use App\Services\Interfaces\IPaymentMethod;
use App\Services\Payments\BlikService;
use App\Services\Payments\PaypalService;
use App\Services\Payments\Przelewy24Service;

enum PaymentMethod
{
    case PRZELEWY24;
    case PAYPAL;
    case BLIK;

    public static function fromString(string $value): self
    {
        return match ($value) {
            'przelewy24' => self::PRZELEWY24,
            'paypal' => self::PAYPAL,
            'blik' => self::BLIK,
        };
    }

    public function getPaymentProcessor(): string
    {
        return match ($this) {
            self::PRZELEWY24 => Przelewy24Service::class,
            self::PAYPAL => PaypalService::class,
            self::BLIK => BlikService::class,
        };
    }
}
