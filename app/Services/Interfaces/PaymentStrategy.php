<?php
declare(strict_types=1);

namespace App\Services\Interfaces;

use App\ValueObjects\Payment;

interface PaymentStrategy
{
    public function isSatisfiedBy(Payment $payment): bool;
}
