<?php

declare(strict_types=1);

namespace TestDoubles\Infrastructure\Application\Service\PaymentProvider;

use TestDoubles\Application\Service\PaymentProvider\PaymentMethodCannotBeAuthorizedException;
use TestDoubles\Application\Service\PaymentProvider\PaymentProvider;
use TestDoubles\Domain\PaymentMethod\PaymentMethod;

class ShutUpTakeMyMoneyPaymentProvider implements PaymentProvider
{
    public function authorize(int $money): PaymentMethod
    {
        if ($money <= 0) {
            throw new PaymentMethodCannotBeAuthorizedException();
        }

        sleep(10);

        return new PaymentMethod();
    }
}
