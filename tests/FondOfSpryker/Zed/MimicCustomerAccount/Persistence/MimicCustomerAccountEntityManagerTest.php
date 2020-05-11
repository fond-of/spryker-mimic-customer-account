<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Persistence;

use Codeception\Test\Unit;
use stdClass;

class MimicCustomerAccountEntityManagerTest extends Unit
{
    /**
     * @var string
     */
    private $customerReference = 'ref-1234';

    /**
     * @var string
     */
    private $quoteUuid = 'uuid-1234';

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $quoteQueryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $quoteEntityMock;

    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Business\MimicCustomerAccountBusinessFactory
     */
    private $entityManager;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->factory = $this->getMockBuilder(MimicCustomerAccountPersistenceFactory::class)
            ->setMethods(['getQuoteQuery'])
            ->getMock();
        $this->quoteQueryMock = $this->getMockBuilder('Orm\Zed\Quote\Persistence\SpyQuoteQuery')
            ->setMethods(['findOneByUuid'])
            ->getMock();

        $this->factory->expects($this->once())
            ->method('getQuoteQuery')
            ->willReturn($this->quoteQueryMock);

        $this->quoteEntityMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['setCustomerReference', 'save'])
            ->getMock();
        $this->entityManager = new MimicCustomerAccountEntityManager();
    }

    /**
     * @return void
     */
    public function testGetCustomerByEmailCustomerFound()
    {
        $this->quoteQueryMock->expects($this->once())
            ->method('findOneByUuid')
            ->with($this->quoteUuid)
            ->willReturn($this->quoteEntityMock);

        $this->quoteEntityMock->expects($this->once())
            ->method('setCustomerReference')
            ->with($this->customerReference);

        $this->quoteEntityMock->expects($this->once())
            ->method('save');

        $this->entityManager->setFactory($this->factory);

        $result = $this->entityManager->updateQuoteCustomerReference($this->quoteUuid, $this->customerReference);
        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testGetCustomerByEmailCustomerNotFound()
    {
        $this->quoteQueryMock->expects($this->once())
            ->method('findOneByUuid')
            ->with($this->quoteUuid)
            ->willReturn(null);

        $this->quoteEntityMock->expects($this->never())
            ->method('setCustomerReference')
            ->with($this->customerReference);

        $this->quoteEntityMock->expects($this->never())
            ->method('save');

        $this->entityManager->setFactory($this->factory);

        $result = $this->entityManager->updateQuoteCustomerReference($this->quoteUuid, $this->customerReference);
        $this->assertFalse($result);
    }
}
