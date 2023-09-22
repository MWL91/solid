<?php

namespace Reservations\DomainModel\Commands;

use Ramsey\Uuid\UuidInterface;
use Reservations\DomainModel\OfficeId;
use Reservations\DomainModel\OfficeName;

final class CreateOfficeCommand
{
    public function __construct(
        private UuidInterface $id,
        private string $name
    )
    {
    }

    public function getId(): OfficeId
    {
        return new OfficeId($this->id);
    }

    public function getName(): OfficeName
    {
        return new OfficeName($this->name);
    }
}
