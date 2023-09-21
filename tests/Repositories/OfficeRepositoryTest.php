<?php

namespace Tests\Repositories;

use App\Models\Office;
use App\Repositories\OfficeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class OfficeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected OfficeRepository $officeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->officeRepo = app(OfficeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_office()
    {
        $office = Office::factory()->make()->toArray();

        $createdOffice = $this->officeRepo->create($office);

        $createdOffice = $createdOffice->toArray();
        $this->assertArrayHasKey('id', $createdOffice);
        $this->assertNotNull($createdOffice['id'], 'Created Office must have id specified');
        $this->assertNotNull(Office::find($createdOffice['id']), 'Office with given id must be in DB');
        $this->assertModelData($office, $createdOffice);
    }

    /**
     * @test read
     */
    public function test_read_office()
    {
        $office = Office::factory()->create();

        $dbOffice = $this->officeRepo->find($office->id);

        $dbOffice = $dbOffice->toArray();
        $this->assertModelData($office->toArray(), $dbOffice);
    }

    /**
     * @test update
     */
    public function test_update_office()
    {
        $office = Office::factory()->create();
        $fakeOffice = Office::factory()->make()->toArray();

        $updatedOffice = $this->officeRepo->update($fakeOffice, $office->id);

        $this->assertModelData($fakeOffice, $updatedOffice->toArray());
        $dbOffice = $this->officeRepo->find($office->id);
        $this->assertModelData($fakeOffice, $dbOffice->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_office()
    {
        $office = Office::factory()->create();

        $resp = $this->officeRepo->delete($office->id);

        $this->assertTrue($resp);
        $this->assertNull(Office::find($office->id), 'Office should not exist in DB');
    }
}
