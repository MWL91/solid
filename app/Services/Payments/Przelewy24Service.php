<?php
declare(strict_types=1);

namespace App\Services\Payments;

use App\Services\Interfaces\IPaymentMethod;
use App\Services\Interfaces\IRecurringPaymentMethod;
use App\ValueObjects\Payment;

final class Przelewy24Service implements IPaymentMethod, IRecurringPaymentMethod
{
    public const NAME = 'przelewy24';

    public function getRedirectUrl(Payment $payment): string
    {
        $url = config(
            'payments.przelewy24.url',
            'https://sandbox.przelewy24.pl/trnRegister'
        );

        return $url . '?price='.$payment->getValue()->getAmount() .
            '&currency=' . $payment->getValue()->getCurrency() .
            '&orderId=' . $payment->getOrderId();
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function subscribe(Payment $payment, \DateTimeInterface $repeatAt): void
    {
        // TODO: Implement subscribe() method.
    }
}
