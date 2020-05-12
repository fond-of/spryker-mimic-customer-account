<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Communication\Plugin\Checkout;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\MimicCustomerAccountFacade;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

class ForceRegisterCustomerOrderSavePluginTest extends Unit
{
    /**
     * @return void
     */
    public function testSaveOrder()
    {
        $plugin = new ForceRegisterCustomerOrderSavePlugin();
        $quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)->getMock();
        $saveOrderTransferMock = $this->getMockBuilder(SaveOrderTransfer::class)->getMock();

        $facade = $this->getMockBuilder(MimicCustomerAccountFacade::class)->getMock();

        $plugin->setFacade($facade);

        $facade->expects($this->once())
            ->method('saveOrderForceRegisterCustomer')
            ->with($quoteTransferMock, $saveOrderTransferMock);

        $plugin->saveOrder($quoteTransferMock, $saveOrderTransferMock);
    }
}
