<?php

declare(strict_types=1);

namespace tests\TestDoubles\Pest\Application\Service\BookingRequest;

use TestDoubles\Application\Service\BookingRequest\TenantBookingRequestCannotBeCreatedException;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestRequest;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestService;
use TestDoubles\Application\Service\PaymentProvider\PaymentMethodCannotBeAuthorizedException;
use TestDoubles\Application\Service\PaymentProvider\PaymentProvider;
use TestDoubles\Domain\BookingRequest\BookingRequest;
use TestDoubles\Domain\PaymentMethod\PaymentMethod;
use TestDoubles\Domain\Tenant\Tenant;
use TestDoubles\Domain\Tenant\TenantRepository;

beforeEach(function (): void {
    $this->tenantRepository = mock(TenantRepository::class);
    $this->paymentProvider = mock(PaymentProvider::class);

    $this->tenantMakeBookingRequestService = new TenantMakeBookingRequestService(
        $this->tenantRepository->expect(),
        $this->paymentProvider->expect()
    );
});

test('tenant make a booking request with mock', function (): void {
    $tenantId = 'tenant-id';
    $price = 100;

    $this->tenantRepository
        ->expects()
        ->findById($tenantId)
        ->once()
        ->andReturn(
            new Tenant()
        );

    $this->paymentProvider
        ->expects()
        ->authorize($price)
        ->once()
        ->andReturn(
            new PaymentMethod()
        );

    assertInstanceOf(
       BookingRequest::class,
       $this->tenantMakeBookingRequestService->execute(
           new TenantMakeBookingRequestRequest($tenantId, $price)
       )
   );
});

test('tenant cannot make a booking request with mock', function (): void {
    $tenantId = 'tenant-id';
    $price = 100;

    $this->tenantRepository
        ->expects()
        ->findById($tenantId)
        ->once()
        ->andReturn(
            new Tenant()
        );

    $this->paymentProvider
        ->expects()
        ->authorize($price)
        ->once()
        ->andThrow(
            new PaymentMethodCannotBeAuthorizedException()
        );

    $this->tenantMakeBookingRequestService->execute(
        new TenantMakeBookingRequestRequest($tenantId, $price)
    );
})->expectException(TenantBookingRequestCannotBeCreatedException::class);
