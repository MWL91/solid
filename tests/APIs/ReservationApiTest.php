<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Reservation;

class ReservationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_reservation()
    {
        $reservation = Reservation::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/reservations', $reservation
        );

        $this->assertApiResponse($reservation);
    }

    /**
     * @test
     */
    public function test_read_reservation()
    {
        $reservation = Reservation::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/reservations/'.$reservation->id
        );

        $this->assertApiResponse($reservation->toArray());
    }

    /**
     * @test
     */
    public function test_update_reservation()
    {
        $reservation = Reservation::factory()->create();
        $editedReservation = Reservation::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/reservations/'.$reservation->id,
            $editedReservation
        );

        $this->assertApiResponse($editedReservation);
    }

    /**
     * @test
     */
    public function test_delete_reservation()
    {
        $reservation = Reservation::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/reservations/'.$reservation->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/reservations/'.$reservation->id
        );

        $this->response->assertStatus(404);
    }
}
