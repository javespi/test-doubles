<?php

declare(strict_types=1);

namespace tests\TestDoubles\Pest\Application\Service\BookingRequest;

use TestDoubles\Application\Service\BookingRequest\TenantBookingRequestCannotBeCreatedException;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestRequest;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestService;
use TestDoubles\Domain\BookingRequest\BookingRequest;
use TestDoubles\Infrastructure\Application\Service\PaymentProvider\ShutUpTakeMyMoneyPaymentProvider;
use TestDoubles\Infrastructure\Persistence\Connection\SlowDriver;
use TestDoubles\Infrastructure\Persistence\Hydrator\TenantHydrator;
use TestDoubles\Infrastructure\Persistence\Tenant\MySqlDatabaseTenantRepository;

beforeEach(function (): void {
    $this->tenantMakeBookingRequestService = new TenantMakeBookingRequestService(
        new MySqlDatabaseTenantRepository(
            new SlowDriver(),
            new TenantHydrator()
        ),
        new ShutUpTakeMyMoneyPaymentProvider()
    );
});

test('tenant make a booking request slowly', function (): void {
    $tenantId = 'tenant-id';
    $price = 100;

    assertInstanceOf(
        BookingRequest::class,
        $this->tenantMakeBookingRequestService->execute(
            new TenantMakeBookingRequestRequest($tenantId, $price)
        )
    );
});

test('tenant cannot make a booking request slowly', function (): void {
    $tenantId = 'tenant-id';
    $price = 0;

    $this->tenantMakeBookingRequestService->execute(
        new TenantMakeBookingRequestRequest($tenantId, $price)
    );
})->expectException(TenantBookingRequestCannotBeCreatedException::class);
