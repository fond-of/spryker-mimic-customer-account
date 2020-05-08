<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface ForceRegisterCustomerOrderSaverInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderForceRegisterCustomer(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void;
}
