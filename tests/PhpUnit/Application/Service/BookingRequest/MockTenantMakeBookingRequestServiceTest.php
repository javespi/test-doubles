<?php

declare(strict_types=1);

namespace tests\TestDoubles\PhpUnit\Application\Service\BookingRequest;

use PHPUnit\Framework\TestCase;
use TestDoubles\Application\Service\BookingRequest\TenantBookingRequestCannotBeCreatedException;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestRequest;
use TestDoubles\Application\Service\BookingRequest\TenantMakeBookingRequestService;
use TestDoubles\Application\Service\PaymentProvider\PaymentMethodCannotBeAuthorizedException;
use TestDoubles\Application\Service\PaymentProvider\PaymentProvider;
use TestDoubles\Domain\BookingRequest\BookingRequest;
use TestDoubles\Domain\PaymentMethod\PaymentMethod;
use TestDoubles\Domain\Tenant\Tenant;
use TestDoubles\Domain\Tenant\TenantRepository;

class MockTenantMakeBookingRequestServiceTest extends TestCase
{
    private TenantMakeBookingRequestService $tenantMakeBookingRequestService;
    private TenantRepository $tenantRepository;
    private PaymentProvider $paymentProvider;

    protected function setUp(): void
    {
        $this->tenantRepository = $this->createMock(TenantRepository::class);
        $this->paymentProvider = $this->createMock(PaymentProvider::class);

        $this->tenantMakeBookingRequestService = new TenantMakeBookingRequestService(
            $this->tenantRepository,
            $this->paymentProvider
        );
    }

    /**
     * @test
     */
    public function execute(): void
    {
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
            ->willReturn(
                new PaymentMethod()
            );

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

        $this->expectException(TenantBookingRequestCannotBeCreatedException::class);

        $this->tenantMakeBookingRequestService->execute(
            new TenantMakeBookingRequestRequest($tenantId, $price)
        );

    }
}
