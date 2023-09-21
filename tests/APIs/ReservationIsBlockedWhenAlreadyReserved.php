<?php

namespace Tests\APIs;

use App\Models\Office;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Reservation;

class ReservationIsBlockedWhenAlreadyReserved extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions, WithFaker;

    /**
     * @test
     */
    public function test_can_not_create_reservation_when_already_reserved()
    {
        // Given:
        $office = Office::factory()->create();
        $reservationRequest = [
            'customer_name' => $this->faker->name(),
            'office_id' => $office->getKey(),
            'reservation_date' => Carbon::now()->format('Y-m-d'),
            'duration' => 2
        ];
        Reservation::factory($reservationRequest)->create();

        // When:
        $this->response = $this->json(
            'POST',
            '/api/reservations',
            $reservationRequest
        );

        // Then:
        $this->response->assertStatus(400);
    }

    public function test_can_not_create_reservation_when_days_overlap()
    {
        // Given:
        $office = Office::factory()->create();
        $reservationRequest = [
            'customer_name' => $this->faker->name(),
            'office_id' => $office->getKey(),
            'reservation_date' => Carbon::now()->format('Y-m-d'),
            'duration' => 2
        ];
        Reservation::factory($reservationRequest)->create();

        // When:
        $reservationRequest['reservation_date'] = Carbon::now()->addDay()->format('Y-m-d');
        $this->response = $this->json(
            'POST',
            '/api/reservations',
            $reservationRequest
        );

        // Then:
        $this->response->assertStatus(400);
    }
}
