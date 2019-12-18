<?php

declare(strict_types=1);

namespace TestDoubles\Application\Service\BookingRequest;

use TestDoubles\Application\Service\PaymentProvider\PaymentMethodCannotBeAuthorizedException;
use TestDoubles\Application\Service\PaymentProvider\PaymentProvider;
use TestDoubles\Domain\BookingRequest\BookingRequest;
use TestDoubles\Domain\Tenant\TenantRepository;

class TenantMakeBookingRequestService
{
    private TenantRepository $tenantRepository;
    private PaymentProvider $paymentProvider;

    public function __construct(
        TenantRepository $tenantRepository,
        PaymentProvider $paymentProvider
    ) {
        $this->tenantRepository = $tenantRepository;
        $this->paymentProvider = $paymentProvider;
    }

    /**
     * @throws TenantBookingRequestCannotBeCreatedException
     */
    public function execute(TenantMakeBookingRequestRequest $request): BookingRequest
    {
        $tenant = $this->tenantRepository->findById($request->tenantId());

        try {
            $paymentMethod = $this->paymentProvider->authorize($request->price());
        } catch (PaymentMethodCannotBeAuthorizedException $exception) {
            throw new TenantBookingRequestCannotBeCreatedException();
        }

        return new BookingRequest(
            $tenant->id(),
            $paymentMethod->id()
        );
    }
}
