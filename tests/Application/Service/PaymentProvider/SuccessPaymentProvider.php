<?php

declare(strict_types=1);

namespace tests\TestDoubles\Application\Service\PaymentProvider;

use TestDoubles\Application\Service\PaymentProvider\PaymentProvider;
use TestDoubles\Domain\PaymentMethod\PaymentMethod;

class SuccessPaymentProvider implements PaymentProvider
{
    public function authorize(int $money): PaymentMethod
    {
        return new PaymentMethod();
    }
}
