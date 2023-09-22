<?php
declare(strict_types=1);

namespace Reservations\DomainModel;

use Ramsey\Uuid\UuidInterface;

final class OfficeId
{
    public function __construct(private UuidInterface $id)
    {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getId()->toString();
    }
}
