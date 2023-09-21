<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Reservation",
 *      required={"customer_name","office_id","reservation_date","duration"},
 *      @OA\Property(
 *          property="customer_name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="reservation_date",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="duration",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */class Reservation extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'reservations';

    public $fillable = [
        'customer_name',
        'office_id',
        'reservation_date',
        'duration'
    ];

    protected $casts = [
        'customer_name' => 'string',
        'reservation_date' => 'date',
        'duration' => 'integer'
    ];

    public static array $rules = [
        'customer_name' => 'required',
        'office_id' => ['required', 'uuid'],
        'reservation_date' => ['required', 'date'],
        'duration' => ['required', 'min:1']
    ];


}
