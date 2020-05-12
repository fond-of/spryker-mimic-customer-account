<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\ForceRegisterCustomerOrderSaver;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaver;
use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountEntityManager;
use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepository;

class MimicCustomerAccountBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Business\MimicCustomerAccountBusinessFactory
     */
    private $factory;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->factory = new MimicCustomerAccountBusinessFactory();
        $repository = $this->getMockBuilder(MimicCustomerAccountRepository::class)->getMock();
        $entityManager = $this->getMockBuilder(MimicCustomerAccountEntityManager::class)->getMock();
        $this->factory->setRepository($repository);
        $this->factory->setEntityManager($entityManager);
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
