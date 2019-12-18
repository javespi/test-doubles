<?php

declare(strict_types=1);

namespace TestDoubles\Infrastructure\Persistence\Tenant;

use TestDoubles\Domain\Tenant\Tenant;
use TestDoubles\Domain\Tenant\TenantRepository;
use TestDoubles\Infrastructure\Persistence\Connection\Driver;
use TestDoubles\Infrastructure\Persistence\Hydrator\TenantHydrator;

class MySqlDatabaseTenantRepository implements TenantRepository
{
    private Driver $driver;
    private TenantHydrator $tenantHydrator;

    public function __construct(
        Driver $driver,
        TenantHydrator $tenantHydrator
    ) {
        $this->driver = $driver;
        $this->tenantHydrator = $tenantHydrator;
    }

    public function findById(string $tenantId): Tenant
    {
        return $this->tenantHydrator->hydrate(
            $this->driver->select("SELECT * FROM tenants WHERE id = {$tenantId}")
        );
    }
}
