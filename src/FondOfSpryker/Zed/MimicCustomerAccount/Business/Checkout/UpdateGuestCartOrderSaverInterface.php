<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface UpdateGuestCartOrderSaverInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderUpdateGuestCart(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void;
}
