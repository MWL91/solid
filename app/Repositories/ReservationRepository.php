<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Repositories\BaseRepository;

class ReservationRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'customer_name',
        'office_id',
        'reservation_date',
        'duration'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Reservation::class;
    }
}
