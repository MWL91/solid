<?php
declare(strict_types=1);

namespace Reservations\DomainModel;

use Ramsey\Uuid\UuidInterface;
use Reservations\DomainModel\Commands\CreateOfficeCommand;

final class OfficeAvailability implements \JsonSerializable
{
    private OfficeId $id;
    private OfficeName $name;
    /** @var Reservation[] */
    private array $reservations = [];
    /** @var \DateTimeInterface[] */
    private array $freeDates = [];

    public static function create(CreateOfficeCommand $command): self
    {
        $office = new self();
        $office->id = $command->getId();
        $office->name = $command->getName();
        return $office;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => (string) $this->name,
            'reservations' => $this->reservations,
            'freeDates' => $this->freeDates,
        ];
    }
}
