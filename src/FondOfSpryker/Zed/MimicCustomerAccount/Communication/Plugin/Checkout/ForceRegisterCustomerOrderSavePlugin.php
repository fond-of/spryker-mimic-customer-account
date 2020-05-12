<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Communication\Plugin\Checkout;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutDoSaveOrderInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\MimicCustomerAccount\Business\MimicCustomerAccountFacade getFacade()
 */
class ForceRegisterCustomerOrderSavePlugin extends AbstractPlugin implements CheckoutDoSaveOrderInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrder(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void
    {
        $this->getFacade()->saveOrderForceRegisterCustomer($quoteTransfer, $saveOrderTransfer);
    }
}
