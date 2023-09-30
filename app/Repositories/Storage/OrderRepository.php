<?php

namespace App\Repositories\Storage;

use App\ValueObjects\CreateNewOrder;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\UuidInterface;

class OrderRepository implements \App\Repositories\OrderRepository
{

    public function create(UuidInterface $id, CreateNewOrder $order): void
    {
        Storage::put('orders/' . $id->toString() . '.json', json_encode($order->toArray()));
    }

    public function setAsPaid(UuidInterface $id, string $paymentMethod): void
    {
        $order = json_decode(Storage::get('orders/' . $id->toString() . '.json'), true);
        $order['payment_type'] = $paymentMethod;
        Storage::put('orders/' . $id->toString() . '.json', json_encode($order));
    }
}
