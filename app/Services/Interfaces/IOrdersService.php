<?php

namespace App\Services\Interfaces;

use App\Enums\PaymentMethod;
use App\ValueObjects\CreateNewOrder;
use App\ValueObjects\Payment;
use Ramsey\Uuid\UuidInterface;

interface IOrdersService
{
    public function create(UuidInterface $id, CreateNewOrder $order): void;

    public function getRedirectUrl(PaymentMethod $paymentMethod, Payment $payment): string;
}
