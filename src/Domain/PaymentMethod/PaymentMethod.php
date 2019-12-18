<?php

declare(strict_types=1);

namespace TestDoubles\Domain\PaymentMethod;

class PaymentMethod
{
    private string $id;

    public function __construct()
    {
        $this->id = 'credit-card-id';
    }

    public function id(): string
    {
        return $this->id;
    }
}
