<?php
declare(strict_types=1);

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Events\OrderCreated;
use App\Repositories\OrderRepository;
use App\Services\Interfaces\IOrdersService;
use App\ValueObjects\CreateNewOrder;
use App\ValueObjects\Payment;
use Illuminate\Contracts\Foundation\Application;
use Ramsey\Uuid\UuidInterface;

final class OrdersService implements IOrdersService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private Application $app
    )
    {
    }

    public function create(UuidInterface $id, CreateNewOrder $order): void
    {
        $this->orderRepository->create($id, $order);
        OrderCreated::dispatch($id, $order);
    }

    public function getRedirectUrl(PaymentMethod $paymentMethod, Payment $payment): string
    {
        $paymentProcessor = $this->app->make($paymentMethod->getPaymentProcessor());

        $url = $paymentProcessor->getRedirectUrl($payment);

        $this->orderRepository->setAsPaid($payment->getOrderId(), $paymentProcessor->getName());

        return $url;
    }
}
