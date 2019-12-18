<?php

declare(strict_types=1);

namespace tests\TestDoubles\Application\Service\BookingRequest;

use PHPUnit\Framework\TestCase;
use TestDoubles\Application\Service\BookingRequest\TenantBookingRequestCannotBeCreatedException;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestRequest;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestService;
use TestDoubles\Domain\BookingRequest\BookingRequest;
use TestDoubles\Infrastructure\Application\Service\PaymentProvider\ShutUpTakeMyMoneyPaymentProvider;
use TestDoubles\Infrastructure\Persistence\Connection\SlowDriver;
use TestDoubles\Infrastructure\Persistence\Hydrator\TenantHydrator;
use TestDoubles\Infrastructure\Persistence\Tenant\MySqlDatabaseTenantRepository;

class SlowestTenantMakeBookingRequestServiceTest extends TestCase
{
    private TenantMakeBookingRequestService $tenantMakeBookingRequestService;

    protected function setUp(): void
    {
        $this->tenantMakeBookingRequestService = new TenantMakeBookingRequestService(
            new MySqlDatabaseTenantRepository(
                new SlowDriver(),
                new TenantHydrator()
            ),
            new ShutUpTakeMyMoneyPaymentProvider()
        );
    }

    /**
     * @test
     */
    public function execute(): void
    {
        $tenantId = 'tenant-id';
        $price = 100;

        $this->assertInstanceOf(
            BookingRequest::class,
            $this->tenantMakeBookingRequestService->execute(
                new TenantMakeBookingRequestRequest($tenantId, $price)
            )
        );
    }

    /**
     * @test
     */
    public function executeOnBookingCannotBeCreated(): void
    {
        $tenantId = 'tenant-id';
        $price = 0;

        $this->expectException(TenantBookingRequestCannotBeCreatedException::class);

        $this->tenantMakeBookingRequestService->execute(
            new TenantMakeBookingRequestRequest($tenantId, $price)
        );
    }
}
