<?php
declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\ValueObjects\CreateNewOrder;
use Ramsey\Uuid\UuidInterface;

final class OrderRepository implements \App\Repositories\OrderRepository
{
    public function create(UuidInterface $id, CreateNewOrder $order): void
    {
        Order::create([
            'id' => $id->toString(),
            ...$order->toArray(),
        ]);
    }
}
