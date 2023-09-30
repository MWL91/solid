<?php

namespace App\Services\Interfaces;

use App\ValueObjects\CreateNewOrder;
use App\ValueObjects\Payment;
use Ramsey\Uuid\UuidInterface;

interface IOrdersService
{
    public function create(UuidInterface $id, CreateNewOrder $order): void;

    public function getRedirectUrl(IPaymentMethod $paymentMethod, Payment $payment): string;
}
