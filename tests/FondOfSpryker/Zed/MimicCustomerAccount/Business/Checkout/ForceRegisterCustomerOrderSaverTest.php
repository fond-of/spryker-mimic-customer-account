<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\MimicCustomerAccount\Dependency\Facade\MimicCustomerAccountToCustomerFacadeInterface;
use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepository;
use Generated\Shared\Transfer\CustomerResponseTransfer;
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
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $registeredCustomerTransfer;

    /**
     * @var string
     */
    private $registeredCustomer = 'ref-1234';

    /**
     * @var string
     */
    private $registeredCustomerId = '1';

    /**
     * @var string
     */
    private $customerEmail = 'foo@bar.com';

    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Dependency\Facade\MimicCustomerAccountToCustomerFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\CustomerResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerResponseTransfer;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)->getMock();
        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)->getMock();

        $this->saveOrderTransferMock = $this->getMockBuilder(SaveOrderTransfer::class)->getMock();

        $this->registeredCustomerTransfer = $this->getMockBuilder(CustomerTransfer::class)->getMock();
        $this->customerFacadeMock = $this->getMockBuilder(MimicCustomerAccountToCustomerFacadeInterface::class)->disableOriginalConstructor()->getMock();
        $this->customerResponseTransfer = $this->getMockBuilder(CustomerResponseTransfer::class)->disableOriginalConstructor()->getMock();
        $this->registeredCustomerTransfer
            ->method('getCustomerReference')
            ->willReturn($this->registeredCustomer);

        $this->registeredCustomerTransfer
            ->method('getIdCustomer')
            ->willReturn($this->registeredCustomerId);
    }

    /**
     * @return void
     */
    public function testNewCustomer()
    {
        $this->customerTransferMock
            ->expects($this->once())
            ->method('setIsGuest');

        $this->customerTransferMock
            ->expects($this->once())
            ->method('requireEmail')
            ->willReturn(true);

        $this->customerTransferMock
            ->expects($this->once())
            ->method('setCustomerReference')
            ->with($this->registeredCustomer)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock
            ->expects($this->once())
            ->method('setIdCustomer')
            ->with($this->registeredCustomerId)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock
            ->expects($this->once())
            ->method('getEmail')
            ->willReturn($this->customerEmail);

        $this->quoteTransferMock->method('getCustomer')->willReturn($this->customerTransferMock);

        $repository = $this->getMockBuilder(MimicCustomerAccountRepository::class)
            ->setMethods(['getCustomerByEmail'])
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->once())
            ->method('getCustomerByEmail')
            ->with($this->stringContains($this->customerEmail))
            ->willReturn($this->registeredCustomerTransfer);

        $this->customerFacadeMock->expects($this->once())
            ->method('registerCustomer')
            ->willReturn($this->customerResponseTransfer);

        $this->customerResponseTransfer->expects($this->once())
            ->method('getCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $forceRegisterCustomerSaver = new ForceRegisterCustomerOrderSaver($this->customerFacadeMock, $repository);

        $forceRegisterCustomerSaver->saveOrderForceRegisterCustomer($this->quoteTransferMock, $this->saveOrderTransferMock);
    }

    /**
     * @return void
     */
    public function testExistingCustomer()
    {
        $this->customerTransferMock
            ->expects($this->once())
            ->method('setIsGuest');

        $this->customerTransferMock
            ->expects($this->once())
            ->method('requireEmail')
            ->willReturn(true);

        $this->customerTransferMock
            ->expects($this->never())
            ->method('setCustomerReference')
            ->with($this->registeredCustomer)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock
            ->expects($this->once())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->customerFacadeMock
            ->expects($this->never())
            ->method('registerCustomer');

        $this->customerTransferMock
            ->expects($this->never())
            ->method('setIdCustomer')
            ->with($this->registeredCustomerId)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock
            ->expects($this->once())
            ->method('getEmail')
            ->willReturn($this->customerEmail);

        $this->quoteTransferMock->method('getCustomer')->willReturn($this->customerTransferMock);

        $repository = $this->getMockBuilder(MimicCustomerAccountRepository::class)
            ->setMethods(['getCustomerByEmail'])
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->once())
            ->method('getCustomerByEmail')
            ->with($this->stringContains($this->customerEmail))
            ->willReturn(null);

        $forceRegisterCustomerSaver = new ForceRegisterCustomerOrderSaver($this->customerFacadeMock, $repository);

        $forceRegisterCustomerSaver->saveOrderForceRegisterCustomer($this->quoteTransferMock, $this->saveOrderTransferMock);
    }
}
