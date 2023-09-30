<?php
declare(strict_types=1);

namespace App\Services\Payments;

use App\Services\Interfaces\IPaymentMethod;
use App\Services\Interfaces\IRecurringPaymentMethod;

final class Przelewy24Service implements IPaymentMethod, IRecurringPaymentMethod
{
    // ...
}
