<?php
declare(strict_types=1);

namespace Reservations\DomainModel;

final class OfficeName
{
    public function __construct(private string $name)
    {
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
