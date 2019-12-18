<?php

declare(strict_types=1);

namespace TestDoubles\Domain\Tenant;

class Tenant
{
    private string $id;

    public function __construct()
    {
        $this->id = 'tenant-id';
    }

    public function id(): string
    {
        return $this->id;
    }
}
