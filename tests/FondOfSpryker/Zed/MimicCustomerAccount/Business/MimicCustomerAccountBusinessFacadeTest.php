<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\ForceRegisterCustomerOrderSaver;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaver;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

class MimicCustomerAccountBusinessFacadeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Business\MimicCustomerAccountFacade
     */
    private $facade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $saveOrderTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $updateGuestCartSaver;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $forceRegisterCustomerSaver;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->facade = new MimicCustomerAccountFacade();
        $this->factory = $this->getMockBuilder(MimicCustomerAccountBusinessFactory::class)->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)->getMock();
        $this->saveOrderTransferMock = $this->getMockBuilder(SaveOrderTransfer::class)->getMock();

        $this->forceRegisterCustomerSaver = $this->getMockBuilder(ForceRegisterCustomerOrderSaver::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->updateGuestCartSaver = $this->getMockBuilder(UpdateGuestCartOrderSaver::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return void
     */
    public function testSaveOrderForceRegisterCustomer()
    {
        $this->factory->expects($this->once())
            ->method('createCheckoutForceRegisterCustomerOrderSaver')
            ->willReturn($this->forceRegisterCustomerSaver);

        $this->forceRegisterCustomerSaver
            ->expects($this->once())
            ->method('saveOrderForceRegisterCustomer')
            ->with($this->quoteTransferMock, $this->saveOrderTransferMock);

        $this->facade->setFactory($this->factory);
        $this->facade->saveOrderForceRegisterCustomer($this->quoteTransferMock, $this->saveOrderTransferMock);
    }

    /**
     * @return void
     */
    public function testSaveOrderUpdateGuestCart()
    {
        $this->factory->expects($this->once())
            ->method('createCheckoutUpdateGuestCartOrderSaver')
            ->willReturn($this->updateGuestCartSaver);

        $this->updateGuestCartSaver
            ->expects($this->once())
            ->method('saveOrderUpdateGuestCart')
            ->with($this->quoteTransferMock, $this->saveOrderTransferMock);

        $this->facade->setFactory($this->factory);
        $this->facade->saveOrderUpdateGuestCart($this->quoteTransferMock, $this->saveOrderTransferMock);
    }
}
