<?php
declare(strict_types=1);

namespace App\Services\Interfaces;

use App\ValueObjects\Payment;

interface IPaymentMethod
{
    public function getRedirectUrl(Payment $payment): string;

    public function getName(): string;

}
