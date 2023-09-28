<?php
declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Money\Currency;
use Money\Money;

final class CreateNewOrder implements Arrayable
{
    private Money $price;
    private bool $isPaid;
    private ?string $paymentMethod;

    public function __construct(
        string $price,
        string $currency,
        bool $isPaid = false,
        ?string $paymentMethod = null)
    {
        $this->price = new Money($price, new Currency($currency));
        $this->isPaid = $isPaid;
        $this->paymentMethod = $paymentMethod;
    }

    public function toArray()
    {
        return [
            'is_paid' => $this->isPaid(),
            'payment_method' => $this->paymentMethod(),
            'minor_amount' => $this->price->getAmount(),
            'currency' => (string) $this->price->getCurrency(),
        ];
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function isPaid(): bool
    {
        return $this->isPaid;
    }

    public function paymentMethod(): ?string
    {
        return $this->paymentMethod;
    }
}
