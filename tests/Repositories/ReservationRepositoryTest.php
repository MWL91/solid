<?php

namespace Tests\Repositories;

use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ReservationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ReservationRepository $reservationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->reservationRepo = app(ReservationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_reservation()
    {
        $reservation = Reservation::factory()->make()->toArray();

        $createdReservation = $this->reservationRepo->create($reservation);

        $createdReservation = $createdReservation->toArray();
        $this->assertArrayHasKey('id', $createdReservation);
        $this->assertNotNull($createdReservation['id'], 'Created Reservation must have id specified');
        $this->assertNotNull(Reservation::find($createdReservation['id']), 'Reservation with given id must be in DB');
        $this->assertModelData($reservation, $createdReservation);
    }

    /**
     * @test read
     */
    public function test_read_reservation()
    {
        $reservation = Reservation::factory()->create();

        $dbReservation = $this->reservationRepo->find($reservation->id);

        $dbReservation = $dbReservation->toArray();
        $this->assertModelData($reservation->toArray(), $dbReservation);
    }

    /**
     * @test update
     */
    public function test_update_reservation()
    {
        $reservation = Reservation::factory()->create();
        $fakeReservation = Reservation::factory()->make()->toArray();

        $updatedReservation = $this->reservationRepo->update($fakeReservation, $reservation->id);

        $this->assertModelData($fakeReservation, $updatedReservation->toArray());
        $dbReservation = $this->reservationRepo->find($reservation->id);
        $this->assertModelData($fakeReservation, $dbReservation->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_reservation()
    {
        $reservation = Reservation::factory()->create();

        $resp = $this->reservationRepo->delete($reservation->id);

        $this->assertTrue($resp);
        $this->assertNull(Reservation::find($reservation->id), 'Reservation should not exist in DB');
    }
}
