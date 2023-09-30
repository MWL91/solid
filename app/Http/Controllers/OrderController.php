<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use App\Services\Interfaces\IOrdersService;
use App\Services\Payments\BlikService;
use App\Services\Payments\PaypalService;
use App\Services\Payments\Przelewy24Service;
use App\ValueObjects\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $url = $this->orderService->getRedirectUrl(
            $request->getPaymentMethod(),
            $request->getPayment()
        );

        return redirect($url);
    }
}
