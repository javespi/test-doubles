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
        $this->tenantRepository,
        $this->paymentProvider
    );
});

test('tenant make a booking request with mock', function (): void {
    $tenantId = 'tenant-id';
    $price = 100;

    $this->tenantRepository
       ->expects(
           $this->once()
       )
       ->method('findById')
       ->with($tenantId)
       ->andReturn(
           new Tenant()
       );

    $this->paymentProvider
       ->expects(
           $this->once()
       )
       ->method('authorize')
       ->with($price)
       ->willReturn(
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
        ->expects(
            $this->once()
        )
        ->method('findById')
        ->with($tenantId)
        ->willReturn(
            new Tenant()
        );

    $this->paymentProvider
        ->expects(
            $this->once()
        )
        ->method('authorize')
        ->with($price)
        ->willThrowException(
            new PaymentMethodCannotBeAuthorizedException()
        );

    $this->tenantMakeBookingRequestService->execute(
        new TenantMakeBookingRequestRequest($tenantId, $price)
    );
})->expectException(TenantBookingRequestCannotBeCreatedException::class);
