<?php

namespace App\Repositories;

use App\ValueObjects\CreateNewOrder;
use Ramsey\Uuid\UuidInterface;

interface OrderRepository
{
    public function create(UuidInterface $id, CreateNewOrder $order): void;
}
