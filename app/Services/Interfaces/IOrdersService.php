<?php

namespace App\Services\Interfaces;

use App\ValueObjects\CreateNewOrder;
use Ramsey\Uuid\UuidInterface;

interface IOrdersService
{
    public function create(UuidInterface $id, CreateNewOrder $order): void;
}
