<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountEntityMangerInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

class UpdateGuestCartOrderSaverTest extends Unit
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
     * @var string
     */
    private $anoymousCustomer = 'anonymous:1234';

    /**
     * @var string
     */
    private $registeredCustomer = 'ref-1234';

    /**
     * @var string
     */
    private $quoteUuid = 'uuid-1234';

    /**
     * @return void
     */
    protected function _before()
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)->getMock();
        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)->getMock();
        $this->quoteTransferMock->method('getCustomer')->willReturn($this->customerTransferMock);

        $this->saveOrderTransferMock = $this->getMockBuilder(SaveOrderTransfer::class)->getMock();
    }

    /**
     * @return void
     */
    public function testAnonymousQuoteTransfer()
    {
        $this->quoteTransferMock
            ->method('getCustomerReference')
            ->willReturn($this->anoymousCustomer);

        $this->quoteTransferMock
            ->expects($this->once())
            ->method('setCustomerReference')
            ->with($this->registeredCustomer);

        $this->quoteTransferMock
            ->method('getUuid')
            ->willReturn($this->quoteUuid);

        $this->customerTransferMock
            ->method('getCustomerReference')
            ->willReturn($this->registeredCustomer);

        $entityManager = $this->getMockBuilder(MimicCustomerAccountEntityMangerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->once())
            ->method('updateQuoteCustomerReference')
            ->with(
                $this->stringContains($this->quoteUuid),
                $this->stringContains($this->registeredCustomer),
            )
            ->willReturn(true);

        $guestCartUpdater = new UpdateGuestCartOrderSaver($entityManager);

        $guestCartUpdater->saveOrderUpdateGuestCart($this->quoteTransferMock, $this->saveOrderTransferMock);
    }

    /**
     * @return void
     */
    public function testAnonymousCustomerQuoteNotFound()
    {
        $this->quoteTransferMock
            ->method('getCustomerReference')
            ->willReturn($this->anoymousCustomer);

        $this->quoteTransferMock
            ->expects($this->never())
            ->method('setCustomerReference')
            ->with($this->registeredCustomer);

        $this->quoteTransferMock
            ->method('getUuid')
            ->willReturn($this->quoteUuid);

        $this->customerTransferMock
            ->method('getCustomerReference')
            ->willReturn($this->registeredCustomer);

        $entityManager = $this->getMockBuilder(MimicCustomerAccountEntityMangerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->once())
            ->method('updateQuoteCustomerReference')
            ->with(
                $this->stringContains($this->quoteUuid),
                $this->stringContains($this->registeredCustomer),
            )
            ->willReturn(false);

        $guestCartUpdater = new UpdateGuestCartOrderSaver($entityManager);

        $guestCartUpdater->saveOrderUpdateGuestCart($this->quoteTransferMock, $this->saveOrderTransferMock);
    }

    /**
     * @return void
     */
    public function testNonAnonymousQuoteTransfer()
    {
        $this->quoteTransferMock
            ->method('getCustomerReference')
            ->willReturn('');

        $this->customerTransferMock
            ->method('getCustomerReference')
            ->willReturn($this->registeredCustomer);

        $entityManager = $this->getMockBuilder(MimicCustomerAccountEntityMangerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->never())
            ->method('updateQuoteCustomerReference')
            ->with(
                $this->stringContains($this->quoteUuid),
                $this->stringContains($this->registeredCustomer),
            )
            ->willReturn(true);

        $guestCartUpdater = new UpdateGuestCartOrderSaver($entityManager);

        $guestCartUpdater->saveOrderUpdateGuestCart($this->quoteTransferMock, $this->saveOrderTransferMock);
    }
}
