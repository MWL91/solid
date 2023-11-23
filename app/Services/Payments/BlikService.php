<?php
declare(strict_types=1);

namespace App\Services\Payments;

use App\Services\Interfaces\IPaymentMethod;
use App\Services\Interfaces\PaymentStrategy;
use App\ValueObjects\Payment;
use Illuminate\Support\Facades\URL;

final class BlikService implements IPaymentMethod, PaymentStrategy
{
    public const NAME = 'blik';

    public function getRedirectUrl(Payment $payment): string
    {
        return URL::to('/blik/'. $payment->getOrderId().
            '?value='.$payment->getValue()->getAmount() .
            '&currency=' . $payment->getValue()->getCurrency()
        );
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function isSatisfiedBy(Payment $payment): bool
    {
        return $payment->getValue()->getAmount() < 1000;
    }
}
