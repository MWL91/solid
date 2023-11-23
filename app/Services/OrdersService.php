<?php
declare(strict_types=1);

namespace App\Services;

use App\Events\OrderCreated;
use App\Repositories\OrderRepository;
use App\Services\Interfaces\IOrdersService;
use App\Services\Interfaces\IPaymentMethod;
use App\Services\Payments\BlikService;
use App\Services\Payments\PaypalService;
use App\Services\Payments\Przelewy24Service;
use App\ValueObjects\CreateNewOrder;
use App\ValueObjects\Payment;
use Ramsey\Uuid\UuidInterface;

final class OrdersService implements IOrdersService
{
    public const PAYMENT_METHODS = [
        'przelewy24' => Przelewy24Service::class,
        'paypal' => PaypalService::class,
        'blik' => BlikService::class,
    ];

    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function create(UuidInterface $id, CreateNewOrder $order): void
    {
        $this->orderRepository->create($id, $order);
        OrderCreated::dispatch($id, $order);
    }

    public function getRedirectUrl(IPaymentMethod $paymentMethod, Payment $payment): string
    {
        $url = $paymentMethod->getRedirectUrl($payment);

        $this->orderRepository->setAsPaid($payment->getOrderId(), $paymentMethod->getName());

        return $url;
    }
}
