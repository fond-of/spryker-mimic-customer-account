<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\MimicCustomerAccount\Business\MimicCustomerAccountBusinessFactory getFactory()
 */
class MimicCustomerAccountFacade extends AbstractFacade implements MimicCustomerAccountFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderForceRegisterCustomer(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void
    {
        $this->getFactory()
            ->createCheckoutForceRegisterCustomerOrderSaver()
            ->saveOrderForceRegisterCustomer($quoteTransfer, $saveOrderTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderUpdateGuestCart(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void
    {
        $this->getFactory()
            ->createCheckoutUpdateGuestCartOrderSaver()
            ->saveOrderUpdateGuestCart($quoteTransfer, $saveOrderTransfer);
    }
}
