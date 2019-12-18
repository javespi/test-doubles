<?php

declare(strict_types=1);

namespace TestDoubles\Domain\BookingRequest;

class BookingRequest
{
    /** @var string */
    private string $tenantId;

    /** @var string */
    private string $paymentMethodId;

    public function __construct(string $tenantId, string $paymentMethodId)
    {
        $this->tenantId = $tenantId;
        $this->paymentMethodId = $paymentMethodId;
    }
}
