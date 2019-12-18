<?php

declare(strict_types=1);

namespace tests\TestDoubles\Application\Service\PaymentProvider;

use TestDoubles\Application\Service\PaymentProvider\PaymentMethodCannotBeAuthorizedException;
use TestDoubles\Application\Service\PaymentProvider\PaymentProvider;
use TestDoubles\Domain\PaymentMethod\PaymentMethod;

class FailurePaymentProvider implements PaymentProvider
{
    public function authorize(int $money): PaymentMethod
    {
        throw new PaymentMethodCannotBeAuthorizedException();
    }
}
