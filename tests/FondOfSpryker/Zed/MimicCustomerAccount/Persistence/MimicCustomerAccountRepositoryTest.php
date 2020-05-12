<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Persistence;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use stdClass;

class MimicCustomerAccountRepositoryTest extends Unit
{
    /**
     * @var string
     */
    private $customerEmail = 'foo@bar.com';

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $customerQueryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $customerEntityMock;

    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Business\MimicCustomerAccountBusinessFactory
     */
    private $repository;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->factory = $this->getMockBuilder(MimicCustomerAccountPersistenceFactory::class)
            ->setMethods(['getCustomerQuery'])
            ->getMock();

        $this->customerQueryMock = $this->getMockBuilder('Orm\Zed\Customer\Persistence\SpyCustomerQuery')
            ->setMethods(['findOneByEmail'])
            ->getMock();

        $this->factory->expects($this->once())
            ->method('getCustomerQuery')
            ->willReturn($this->customerQueryMock);

        $this->customerEntityMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['toArray'])
            ->getMock();
        $this->customerEntityMock->method('toArray')->willReturn([]);

        $this->repository = new MimicCustomerAccountRepository();
    }

    /**
     * @return void
     */
    public function testGetCustomerByEmailCustomerFound()
    {
        $this->customerQueryMock->expects($this->once())
            ->method('findOneByEmail')
            ->with($this->customerEmail)
            ->willReturn($this->customerEntityMock);

        $this->repository->setFactory($this->factory);

        $result = $this->repository->getCustomerByEmail($this->customerEmail);
        $this->assertInstanceOf(CustomerTransfer::class, $result);
    }

    /**
     * @return void
     */
    public function testGetCustomerByEmailCustomerNotFound()
    {
        $this->customerQueryMock->expects($this->once())
            ->method('findOneByEmail')
            ->with($this->customerEmail)
            ->willReturn(null);

        $this->repository->setFactory($this->factory);

        $result = $this->repository->getCustomerByEmail($this->customerEmail);
        $this->assertNull($result);
    }
}
