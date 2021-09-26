<?php

declare(strict_types=1);

namespace tests\TestDoubles\Pest\Application\Service\BookingRequest;

use TestDoubles\Application\Service\BookingRequest\TenantBookingRequestCannotBeCreatedException;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestRequest;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestService;
use TestDoubles\Domain\BookingRequest\BookingRequest;
use tests\TestDoubles\Application\Service\PaymentProvider\FailurePaymentProvider;
use tests\TestDoubles\Application\Service\PaymentProvider\SuccessPaymentProvider;
use tests\TestDoubles\Domain\Tenant\FakeTenantRepository;

test('tenant make a booking request', function (): void {
    $tenantMakeBookingRequestService = new TenantMakeBookingRequestService(
       new FakeTenantRepository(),
       new SuccessPaymentProvider()
   );

    assertInstanceOf(
       BookingRequest::class,
       $tenantMakeBookingRequestService->execute(
           new TenantMakeBookingRequestRequest('tenant-id', 100)
       )
   );
});

test('tenant cannot make a booking request', function (): void {
    (new TenantMakeBookingRequestService(
       new FakeTenantRepository(),
       new FailurePaymentProvider()
   ))->execute(
       new TenantMakeBookingRequestRequest('tenant-id', 100)
   );
})->throws(TenantBookingRequestCannotBeCreatedException::class);
