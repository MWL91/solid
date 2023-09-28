<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\BlikService;
use App\Services\PayPalService;
use App\Services\Przelewy24Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Uuid;

class OrderController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $id = Uuid::uuid4();

        $order = Order::create([
            'id' => $id->toString(),
            'is_paid' => false,
            'payment_method' => null,
            'minor_amount' => $request->get('price') * 100,
            'currency' => $request->get('currency')
        ]);

        return new JsonResponse($order);
    }

    public function pay(Request $request)
    {
        $order = Order::where('id', $request->get('order_id'))->first();

        switch($request->get('payment_method')) {
            case 'przelewy24':
                $processor = new Przelewy24Service($request->get('order_id'), $request->get('price'), $request->get('currency'));
                $url = $processor->paymentUrl();
                break;
            case 'paypal':
                $processor = new PayPalService($request->get('order_id'));
                $url = $processor->redirectAddress($request->get('price'), $request->get('currency'), true);
                break;
            case 'blik':
                $processor = new BlikService();
                $blikHash = $processor->getHash($request->get('order_id'), $request->get('price'));
                break;
            default:
                return new JsonResponse([
                    'message' => 'Unknown payment method'
                ], 400);
        }

        if(isset($blikHash)) {
            $blikSended = $processor->sendBlik($blikHash, $request->get('code'));

            if($blikSended) {
                $order->update([
                    'is_paid' => true,
                    'payment_method' => 'blik'
                ]);
            } else {
                return new JsonResponse([
                    'message' => 'Blik code is invalid'
                ], 400);
            }
        }

        $order->update([
            'is_paid' => true,
            'payment_method' => $request->get('payment_method')
        ]);

        if(isset($url)) {
            return redirect($url);
        }

        return new JsonResponse([
            'message' => 'Payment successful'
        ]);
    }
}
