<?php

declare(strict_types=1);

namespace tests\TestDoubles\Domain\Tenant;

use TestDoubles\Domain\Tenant\Tenant;
use TestDoubles\Domain\Tenant\TenantRepository;

class FakeTenantRepository implements TenantRepository
{
    public function findById(string $tenantId): Tenant
    {
        return new Tenant();
    }
}
