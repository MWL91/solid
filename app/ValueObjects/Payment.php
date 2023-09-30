<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Payment implements Arrayable
{
    private UuidInterface $orderId;
    private Money $value;

    public function __construct(
        string $orderId,
        string $price,
        string $currency
    )
    {
        $this->orderId = Uuid::fromString($orderId);
        $this->value = new Money($price, new Currency($currency));
    }

    public function toArray()
    {
        return [
            'order_id' => $this->orderId->toString(),
            'price' => $this->value->getAmount(),
            'currency' => (string) $this->value->getCurrency()
        ];
    }

    public function getOrderId(): UuidInterface
    {
        return $this->orderId;
    }

    public function getValue(): Money
    {
        return $this->value;
    }
}
