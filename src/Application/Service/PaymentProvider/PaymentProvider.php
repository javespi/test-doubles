<?php

declare(strict_types=1);

namespace TestDoubles\Application\Service\PaymentProvider;

use TestDoubles\Domain\PaymentMethod\PaymentMethod;

interface PaymentProvider
{
    /**
     * @throws PaymentMethodCannotBeAuthorizedException
     */
    public function authorize(int $money): PaymentMethod;
}
