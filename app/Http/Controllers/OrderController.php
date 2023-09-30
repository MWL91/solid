<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
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

    public function pay(Request $request)
    {
        $order = Order::where('id', $request->get('order_id'))->first();

        switch($request->get('payment_method')) {
            case 'przelewy24':
                $processor = new Przelewy24Service();
                $url = $processor->getRedirectUrl(new Payment(
                    $request->get('order_id'),
                    $request->get('price'),
                    $request->get('currency')
                ));
                break;
            case 'paypal':
                $processor = new PaypalService();
                $url = $processor->getRedirectUrl(new Payment(
                    $request->get('order_id'),
                    $request->get('price'),
                    $request->get('currency')
                ));
                break;
            case 'blik':
                $processor = new BlikService();
                $url = $processor->getRedirectUrl(new Payment(
                    $request->get('order_id'),
                    $request->get('price'),
                    $request->get('currency')
                ));
                break;
            default:
                abort(404);
        }

        $order->update([
            'is_paid' => true,
            'payment_method' => $request->get('payment_method')
        ]);

        return redirect($url);
    }
}
