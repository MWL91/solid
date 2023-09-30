<?php
declare(strict_types=1);

namespace App\Services;

use App\Events\OrderCreated;
use App\Repositories\OrderRepository;
use App\Services\Interfaces\IOrdersService;
use App\Services\Interfaces\IPaymentMethod;
use App\ValueObjects\CreateNewOrder;
use App\ValueObjects\Payment;
use Ramsey\Uuid\UuidInterface;

final class OrdersService implements IOrdersService
{
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
