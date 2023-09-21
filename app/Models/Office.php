<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Office",
 *      required={"name","location"},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="location",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
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
 */class Office extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'offices';

    public $fillable = [
        'name',
        'location'
    ];

    protected $casts = [
        'name' => 'string',
        'location' => 'string'
    ];

    public static array $rules = [
        'name' => 'required',
        'location' => 'required'
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }


}
