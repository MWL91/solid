<?php
declare(strict_types=1);

namespace App\Services\Payments;

use App\Services\Interfaces\IPaymentMethod;
use App\Services\Interfaces\IRecurringPaymentMethod;
use App\Services\Interfaces\PaymentStrategy;
use App\ValueObjects\Payment;

final class PaypalService implements IPaymentMethod, IRecurringPaymentMethod, PaymentStrategy
{
    public const NAME = 'paypal';

    public function getRedirectUrl(Payment $payment): string
    {
        $url = config(
            'payments.paypal.url',
            'https://www.sandbox.paypal.com/cgi-bin/webscr'
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

    public function isSatisfiedBy(Payment $payment): bool
    {
        return $payment->getCurrency() !== 'PLN';
    }
}
