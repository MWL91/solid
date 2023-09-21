<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateOfficeAPIRequest;
use App\Http\Requests\API\UpdateOfficeAPIRequest;
use App\Models\Office;
use App\Repositories\OfficeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class OfficeController
 */

class OfficeAPIController extends AppBaseController
{
    private OfficeRepository $officeRepository;

    public function __construct(OfficeRepository $officeRepo)
    {
        $this->officeRepository = $officeRepo;
    }

    /**
     * @OA\Get(
     *      path="/offices",
     *      summary="getOfficeList",
     *      tags={"Office"},
     *      description="Get all Offices",
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
     *                  @OA\Items(ref="#/components/schemas/Office")
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
        $offices = $this->officeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($offices->toArray(), 'Offices retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/offices",
     *      summary="createOffice",
     *      tags={"Office"},
     *      description="Create Office",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Office")
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
     *                  ref="#/components/schemas/Office"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateOfficeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $office = $this->officeRepository->create($input);

        return $this->sendResponse($office->toArray(), 'Office saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/offices/{id}",
     *      summary="getOfficeItem",
     *      tags={"Office"},
     *      description="Get Office",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Office",
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
     *                  ref="#/components/schemas/Office"
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
        /** @var Office $office */
        $office = $this->officeRepository->find($id);

        if (empty($office)) {
            return $this->sendError('Office not found');
        }

        return $this->sendResponse($office->toArray(), 'Office retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/offices/{id}",
     *      summary="updateOffice",
     *      tags={"Office"},
     *      description="Update Office",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Office",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Office")
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
     *                  ref="#/components/schemas/Office"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateOfficeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Office $office */
        $office = $this->officeRepository->find($id);

        if (empty($office)) {
            return $this->sendError('Office not found');
        }

        $office = $this->officeRepository->update($input, $id);

        return $this->sendResponse($office->toArray(), 'Office updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/offices/{id}",
     *      summary="deleteOffice",
     *      tags={"Office"},
     *      description="Delete Office",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Office",
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
        /** @var Office $office */
        $office = $this->officeRepository->find($id);

        if (empty($office)) {
            return $this->sendError('Office not found');
        }

        $office->delete();

        return $this->sendSuccess('Office deleted successfully');
    }
}
