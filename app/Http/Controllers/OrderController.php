<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\PaymentRequest;
use App\Services\Interfaces\IOrdersService;
use App\Services\OrdersService;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;

class OrderController extends Controller
{


    public function __construct(private IOrdersService $orderService)
    {
    }

    public function create(CreateOrderRequest $request): JsonResponse
    {
        $id = Uuid::uuid4();

        $this->orderService->create($id, $request->getOrder());

        return new JsonResponse([
            'id' => $id->toString()
        ]);
    }

    public function pay(PaymentRequest $request)
    {
        $processor = new OrdersService::PAYMENT_METHODS[$request->get('payment_method')];
        $url = $this->orderService->getRedirectUrl($processor, $request->getPayment());

        return redirect($url);
    }
}
