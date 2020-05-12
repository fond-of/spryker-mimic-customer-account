<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface MimicCustomerAccountFacadeInterface
{
    /**
     * Specification:
     * - Check if customer already exists in database
     * - Update customer transfer with existing id and reference
     * - Force isGuest to be false
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderForceRegisterCustomer(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void;

    /**
     * Specification:
     * - Validate if the quote is anonymous
     * - Update customer reference for quote identified by uuid
     * - Update quote transfer if quote has been updated
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderUpdateGuestCart(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void;
}
