<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReservationAPIRequest;
use App\Http\Requests\API\UpdateReservationAPIRequest;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ReservationController
 */

class ReservationAPIController extends AppBaseController
{
    private ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepo)
    {
        $this->reservationRepository = $reservationRepo;
    }

    /**
     * @OA\Get(
     *      path="/reservations",
     *      summary="getReservationList",
     *      tags={"Reservation"},
     *      description="Get all Reservations",
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
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Reservation")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $reservations = $this->reservationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($reservations->toArray(), 'Reservations retrieved successfully');
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
    public function store(CreateReservationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $existingReservation = Reservation::where('office_id', $request->get('office_id'))
            ->whereBetween('reservation_date', [
                $request->date('reservation_date'),
                $request->date('reservation_date')->addDays($request->get('duration') - 1)
            ])
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

    /**
     * @OA\Get(
     *      path="/reservations/{id}",
     *      summary="getReservationItem",
     *      tags={"Reservation"},
     *      description="Get Reservation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Reservation",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
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
    public function show($id): JsonResponse
    {
        /** @var Reservation $reservation */
        $reservation = $this->reservationRepository->find($id);

        if (empty($reservation)) {
            return $this->sendError('Reservation not found');
        }

        return $this->sendResponse($reservation->toArray(), 'Reservation retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/reservations/{id}",
     *      summary="updateReservation",
     *      tags={"Reservation"},
     *      description="Update Reservation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Reservation",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
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
    public function update($id, UpdateReservationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Reservation $reservation */
        $reservation = $this->reservationRepository->find($id);

        if (empty($reservation)) {
            return $this->sendError('Reservation not found');
        }

        $reservation = $this->reservationRepository->update($input, $id);

        return $this->sendResponse($reservation->toArray(), 'Reservation updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/reservations/{id}",
     *      summary="deleteReservation",
     *      tags={"Reservation"},
     *      description="Delete Reservation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Reservation",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
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
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Reservation $reservation */
        $reservation = $this->reservationRepository->find($id);

        if (empty($reservation)) {
            return $this->sendError('Reservation not found');
        }

        $reservation->delete();

        return $this->sendSuccess('Reservation deleted successfully');
    }
}
