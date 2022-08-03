<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\ForceRegisterCustomerOrderSaver;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaver;
use FondOfSpryker\Zed\MimicCustomerAccount\Dependency\Facade\MimicCustomerAccountToCustomerFacadeInterface;
use FondOfSpryker\Zed\MimicCustomerAccount\MimicCustomerAccountDependencyProvider;
use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountEntityManager;
use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepository;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use Spryker\Zed\Kernel\Container;

class MimicCustomerAccountBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Business\MimicCustomerAccountBusinessFactory
     */
    private $factory;

    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $containerMock;

    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Dependency\Facade\MimicCustomerAccountToCustomerFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerFacadeMock;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->factory = new MimicCustomerAccountBusinessFactory();
        $repository = $this->getMockBuilder(MimicCustomerAccountRepository::class)->getMock();
        $entityManager = $this->getMockBuilder(MimicCustomerAccountEntityManager::class)->getMock();
        $config = $this->getMockBuilder(AbstractBundleConfig::class)->getMock();
        $this->containerMock = $this->getMockBuilder(Container::class)->disableOriginalConstructor()->getMock();
        $this->customerFacadeMock = $this->getMockBuilder(MimicCustomerAccountToCustomerFacadeInterface::class)->disableOriginalConstructor()->getMock();
        $this->factory->setRepository($repository);
        $this->factory->setEntityManager($entityManager);
        $this->factory->setConfig($config);
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCheckoutForceRegisterCustomerOrderSaver()
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [MimicCustomerAccountDependencyProvider::FACADE_CUSTOMER],
            )->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [MimicCustomerAccountDependencyProvider::FACADE_CUSTOMER],
            )
            ->willReturnOnConsecutiveCalls(
                $this->customerFacadeMock,
            );

        $saver = $this->factory->createCheckoutForceRegisterCustomerOrderSaver();
        $this->assertInstanceOf(ForceRegisterCustomerOrderSaver::class, $saver);
    }

    /**
     * @return void
     */
    public function testCreateCheckoutUpdateGuestCartOrderSaver()
    {
        $saver = $this->factory->createCheckoutUpdateGuestCartOrderSaver();
        $this->assertInstanceOf(UpdateGuestCartOrderSaver::class, $saver);
    }
}
