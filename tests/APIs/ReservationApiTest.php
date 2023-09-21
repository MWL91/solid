<?php

namespace Tests\APIs;

use App\Models\Office;
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
        $reservation = Reservation::factory([
            'office_id' => Office::factory()->create()
        ])->make()->toArray();

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
        $reservation = Reservation::factory([
            'office_id' => Office::factory()->create()
        ])->create();

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
        $reservation = Reservation::factory([
            'office_id' => $office_id = Office::factory()->create()
        ])->create();
        $editedReservation = Reservation::factory(['office_id' => $office_id])->make()->toArray();

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
        $reservation = Reservation::factory([
            'office_id' => Office::factory()->create()
        ])->create();

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
