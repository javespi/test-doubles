<?php

declare(strict_types=1);

namespace tests\TestDoubles\PhpUnit\Application\Service\BookingRequest;

use PHPUnit\Framework\TestCase;
use TestDoubles\Application\Service\BookingRequest\TenantBookingRequestCannotBeCreatedException;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestRequest;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestService;
use TestDoubles\Domain\BookingRequest\BookingRequest;
use tests\TestDoubles\Application\Service\PaymentProvider\FailurePaymentProvider;
use tests\TestDoubles\Application\Service\PaymentProvider\SuccessPaymentProvider;
use tests\TestDoubles\Domain\Tenant\FakeTenantRepository;

class TenantMakeBookingRequestServiceTest extends TestCase
{
    /**
     * @test
     */
    public function execute(): void
    {
        $tenantMakeBookingRequestService = new TenantMakeBookingRequestService(
            new FakeTenantRepository(),
            new SuccessPaymentProvider()
        );

        $this->assertInstanceOf(
            BookingRequest::class,
            $tenantMakeBookingRequestService->execute(
                new TenantMakeBookingRequestRequest('tenant-id', 100)
            )
        );
    }

    /**
     * @test
     */
    public function executeOnBookingCannotBeCreated(): void
    {
        $this->expectException(TenantBookingRequestCannotBeCreatedException::class);

        (new TenantMakeBookingRequestService(
            new FakeTenantRepository(),
            new FailurePaymentProvider()
        ))->execute(
            new TenantMakeBookingRequestRequest('tenant-id', 100)
        );
    }
}
