<?php
declare(strict_types=1);

namespace App\Services\Interfaces;

use App\ValueObjects\Payment;

interface IRecurringPaymentMethod
{
    public function subscribe(Payment $payment, \DateTimeInterface $repeatAt): void;

    public function getName(): string;
}
