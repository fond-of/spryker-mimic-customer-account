<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

class ForceRegisterCustomerOrderSaverTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockBuilder
     */
    private $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $saveOrderTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $customerTransferMock;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)->getMock();
        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)->getMock();

        $this->saveOrderTransferMock = $this->getMockBuilder(SaveOrderTransfer::class)->getMock();
    }

    /**
     * @return void
     */
    public function testAnonymousQuoteTransfer()
    {
        $this->quoteTransferMock->setCustomerReference('anonymous:1234');
        $this->customerTransferMock->setCustomerReference('ref-1234');
        $this->quoteTransferMock->setCustomer($this->customerTransferMock);

        $repository = $this->getMockBuilder(MimicCustomerAccountRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->never())
            ->method('updateQuoteCustomerReference')
            ->with([
                $this->stringContains('uuid-1234'),
                $this->stringContains('ref-1234'),
            ])
            ->willReturn(true);

        $guestCartUpdater = new UpdateGuestCartOrderSaver($repository);

        $guestCartUpdater->saveOrderUpdateGuestCart($this->quoteTransferMock, $this->saveOrderTransferMock);
    }

    /**
     * @return void
     */
    public function testNonAnonymousQuoteTransfer()
    {
        $quoteTransfer = new QuoteTransfer();
        $saveOrderTransfer = new SaveOrderTransfer();

        $repository = $this->getMockBuilder(MimicCustomerAccountRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->never())
            ->method('updateQuoteCustomerReference');

        $guestCartUpdater = new UpdateGuestCartOrderSaver($repository);

        $guestCartUpdater->saveOrderUpdateGuestCart($quoteTransfer, $saveOrderTransfer);
    }
}
