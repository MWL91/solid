<?php
declare(strict_types=1);

namespace Reservations\Tests\Unit;

use Ramsey\Uuid\Uuid;
use Reservations\DomainModel\Commands\CreateOfficeCommand;
use Reservations\DomainModel\OfficeAvailability;

final class CreateReservationTest extends \PHPUnit\Framework\TestCase
{
    public function testItShouldCreateOffice(): void
    {
        // Given:
        $officeId = Uuid::uuid4();
        $createOfficeCommand = new CreateOfficeCommand(
            $officeId,
            'Office 1'
        );

        // When:
        $office = OfficeAvailability::create($createOfficeCommand);

        // Then:
        $this->assertInstanceOf(OfficeAvailability::class, $office);
    }
}
