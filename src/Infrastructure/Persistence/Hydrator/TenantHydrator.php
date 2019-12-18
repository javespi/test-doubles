<?php

declare(strict_types=1);

namespace TestDoubles\Infrastructure\Persistence\Hydrator;

use TestDoubles\Domain\Tenant\Tenant;

class TenantHydrator
{
    public function hydrate(array $data): Tenant
    {
        return new Tenant();
    }
}
