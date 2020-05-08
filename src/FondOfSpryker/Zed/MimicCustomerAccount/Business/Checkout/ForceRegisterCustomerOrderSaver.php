<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout;

use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

class ForceRegisterCustomerOrderSaver implements ForceRegisterCustomerOrderSaverInterface
{
    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface
     */
    private $repository;

    /**
     * @param \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface $repository
     */
    public function __construct(MimicCustomerAccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderForceRegisterCustomer(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void
    {
        $customerTransfer = $quoteTransfer->getCustomer();

        $customerTransfer->requireEmail();

        $existingCustomer = $this->getCustomerByEmail($customerTransfer->getEmail());
        if ($existingCustomer !== null) {
            $customerTransfer
                ->setIdCustomer($existingCustomer->getIdCustomer())
                ->setCustomerReference($existingCustomer->getCustomerReference());
        }

        $customerTransfer->setIsGuest(false);
    }

    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function getCustomerByEmail(string $email): ?CustomerTransfer
    {
        $customerTransfer = $this->repository->getCustomerByEmail($email);

        if ($customerTransfer === null) {
            return null;
        }

        return $customerTransfer;
    }
}
