<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout;

use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountEntityMangerInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

class UpdateGuestCartOrderSaver implements UpdateGuestCartOrderSaverInterface
{
    private const ANONYMOUS_IDENTIFIER = 'anonymous:';
    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountEntityMangerInterface
     */
    private $entityManager;

    /**
     * @param \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountEntityMangerInterface $entityManager
     */
    public function __construct(MimicCustomerAccountEntityMangerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderUpdateGuestCart(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void
    {
        $updated = false;
        $customerTransfer = $quoteTransfer->getCustomer();
        $quoteCustomerRefernce = $quoteTransfer->getCustomerReference();

        if (strstr($quoteCustomerRefernce, static::ANONYMOUS_IDENTIFIER)
            && $customerTransfer->getCustomerReference() !== null
        ) {
            $updated = $this->updateGuestCartCustomerReference($quoteTransfer->getUuid(), $customerTransfer->getCustomerReference());
        }

        if ($updated) {
            $quoteTransfer->setCustomerReference($customerTransfer->getCustomerReference());
        }
    }

    /**
     * @param string $uuid
     * @param string $customerReference
     *
     * @return bool
     */
    protected function updateGuestCartCustomerReference(string $uuid, string $customerReference): bool
    {
        return $this->entityManager->updateQuoteCustomerReference($uuid, $customerReference);
    }
}
