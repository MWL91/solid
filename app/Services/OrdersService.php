<?php
declare(strict_types=1);

namespace App\Services;

use App\Events\OrderCreated;
use App\Repositories\OrderRepository;
use App\Services\Interfaces\IOrdersService;
use App\Services\Interfaces\PaymentStrategy;
use App\ValueObjects\CreateNewOrder;
use App\ValueObjects\Payment;
use Illuminate\Contracts\Foundation\Application;
use Ramsey\Uuid\UuidInterface;

final class OrdersService implements IOrdersService
{
    private const STRATEGIES = [
        \App\Services\Payments\BlikService::class,
        \App\Services\Payments\Przelewy24Service::class,
        \App\Services\Payments\PaypalService::class
    ];

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

    public function getRedirectUrl(Payment $payment): string
    {
        $paymentProcessor = $this->getProcessor($payment);

        $url = $paymentProcessor->getRedirectUrl($payment);

        $this->orderRepository->setAsPaid($payment->getOrderId(), $paymentProcessor->getName());

        return $url;
    }

    /**
     * @param Payment $payment
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function getProcessor(Payment $payment): ?PaymentStrategy
    {
        $paymentProcessor = null;
        foreach (self::STRATEGIES as $strategy) {
            $paymentProcessor = $this->app->make($strategy);
            if ($paymentProcessor->isSatisfiedBy($payment)) {
                return $paymentProcessor;
            }
        }

        if($paymentProcessor === null) {
            throw new \Exception('No payment processor found');
        }

        return null;
    }
}
