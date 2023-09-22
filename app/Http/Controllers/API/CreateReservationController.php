<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReservationAPIRequest;
use App\Http\Requests\API\UpdateReservationAPIRequest;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;

class CreateReservationController extends AppBaseController
{
    private ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepo)
    {
        $this->reservationRepository = $reservationRepo;
    }

    /**
     * @OA\Post(
     *      path="/reservations",
     *      summary="createReservation",
     *      tags={"Reservation"},
     *      description="Create Reservation",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Reservation")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Reservation"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function __invoke(CreateReservationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $existingReservation = Reservation::query()
            ->where(
                'office_id',
                $request->get('office_id')
            )
            ->where(
                DB::raw('DATE(reservation_date + duration)'),
                '>=',
                $request->date('reservation_date')
            )
            ->where(
                'reservation_date',
                '<=',
                $request->date('reservation_date')->addDays($request->get('duration') - 1)
            )
            ->exists();

        if($existingReservation) {
            return new JsonResponse([
                'success' => false,
                'message' => 'This office is already reserved for this date'
            ], 400);
        }

        $reservation = $this->reservationRepository->create($input);

        return $this->sendResponse($reservation->toArray(), 'Reservation saved successfully');
    }
}
