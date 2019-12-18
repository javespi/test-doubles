<?php

declare(strict_types=1);

namespace TestDoubles\Application\Service\BookingRequest;

class TenantMakeBookingRequestRequest
{
    private string $tenantId;
    private int $price;

    public function __construct(
        string $tenantId,
        int $price
    ) {
        $this->tenantId = $tenantId;
        $this->price = $price;
    }

    public function tenantId(): string
    {
        return $this->tenantId;
    }

    public function price(): int
    {
        return $this->price;
    }
}
