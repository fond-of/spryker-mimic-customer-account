<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\ForceRegisterCustomerOrderSaver;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaver;
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
     * @return void
     */
    protected function _before()
    {
        $this->factory = new MimicCustomerAccountBusinessFactory();
        $repository = $this->getMockBuilder(MimicCustomerAccountRepository::class)->getMock();
        $entityManager = $this->getMockBuilder(MimicCustomerAccountEntityManager::class)->getMock();
        $config = $this->getMockBuilder(AbstractBundleConfig::class)->getMock();
        $this->containerMock = $this->getMockBuilder(Container::class)->disableOriginalConstructor()->getMock();
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
