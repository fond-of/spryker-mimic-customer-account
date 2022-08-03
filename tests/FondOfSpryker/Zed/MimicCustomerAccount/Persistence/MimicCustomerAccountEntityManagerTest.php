<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Persistence;

use Codeception\Test\Unit;
use Orm\Zed\Quote\Persistence\SpyQuote;
use Orm\Zed\Quote\Persistence\SpyQuoteQuery;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Quote\Persistence\SpyQuoteQuery
     */
    private $quoteQueryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Quote\Persistence\SpyQuote
     */
    private $quoteEntityMock;

    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountEntityMangerInterface
     */
    private $entityManager;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->factory = $this->getMockBuilder(MimicCustomerAccountPersistenceFactory::class)->disableOriginalConstructor()
            ->getMock();
        $this->quoteQueryMock = $this->getMockBuilder(SpyQuoteQuery::class)->disableOriginalConstructor()
            ->getMock();

        $this->factory->expects($this->once())
            ->method('getQuoteQuery')
            ->willReturn($this->quoteQueryMock);

        $this->quoteEntityMock = $this->getMockBuilder(SpyQuote::class)->disableOriginalConstructor()
            ->getMock();
        $this->entityManager = new MimicCustomerAccountEntityManager();
        $this->entityManager->setFactory($this->factory);
    }

    /**
     * @return void
     */
    public function testGetCustomerByEmailCustomerFound()
    {
        $this->quoteQueryMock->expects($this->once())
            ->method('filterByUuid')
            ->with($this->quoteUuid)
            ->willReturnSelf();

        $this->quoteQueryMock->expects($this->once())
            ->method('findOne')
            ->willReturn($this->quoteEntityMock);

        $this->quoteEntityMock->expects($this->once())
            ->method('setCustomerReference')
            ->with($this->customerReference);

        $this->quoteEntityMock->expects($this->once())
            ->method('save');

        $result = $this->entityManager->updateQuoteCustomerReference($this->quoteUuid, $this->customerReference);
        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testGetCustomerByEmailCustomerNotFound()
    {
        $this->quoteQueryMock->expects($this->once())
            ->method('filterByUuid')
            ->with($this->quoteUuid)
            ->willReturnSelf();

        $this->quoteQueryMock->expects($this->once())
            ->method('findOne')
            ->willReturn(null);

        $this->quoteEntityMock->expects($this->never())
            ->method('setCustomerReference')
            ->with($this->customerReference);

        $this->quoteEntityMock->expects($this->never())
            ->method('save');

        $result = $this->entityManager->updateQuoteCustomerReference($this->quoteUuid, $this->customerReference);
        $this->assertFalse($result);
    }
}
