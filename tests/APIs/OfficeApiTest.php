<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Office;

class OfficeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_office()
    {
        $office = Office::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/offices', $office
        );

        $this->assertApiResponse($office);
    }

    /**
     * @test
     */
    public function test_read_office()
    {
        $office = Office::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/offices/'.$office->id
        );

        $this->assertApiResponse($office->toArray());
    }

    /**
     * @test
     */
    public function test_update_office()
    {
        $office = Office::factory()->create();
        $editedOffice = Office::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/offices/'.$office->id,
            $editedOffice
        );

        $this->assertApiResponse($editedOffice);
    }

    /**
     * @test
     */
    public function test_delete_office()
    {
        $office = Office::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/offices/'.$office->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/offices/'.$office->id
        );

        $this->response->assertStatus(404);
    }
}
