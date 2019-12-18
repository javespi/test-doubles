<?php

declare(strict_types=1);

namespace TestDoubles\Domain\Tenant;

interface TenantRepository
{
    public function findById(string $tenantId): Tenant;
}
