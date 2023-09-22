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
        $officeJson = $office->jsonSerialize();

        // Then:
        $this->assertInstanceOf(OfficeAvailability::class, $office);
        $this->assertEquals($officeId, $officeJson['id']);
        $this->assertEquals('Office 1', $officeJson['name']);
        $this->assertEmpty($officeJson['reservations']);
        $this->assertEmpty($officeJson['freeDates']);
    }
}
