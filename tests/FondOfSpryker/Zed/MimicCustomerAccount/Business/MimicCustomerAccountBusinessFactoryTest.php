<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\RegisterCustomerOrderSaverInterface;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaverInterface;

class MimicCustomerAccountBusinessFactoryTest extends Unit
{
    /**
     * @return void
     */
    public function testCreateRegisterCustomerOrderSaver(): void
    {
        $factory = new MimicCustomerAccountBusinessFactory();
        $orderSaver = $factory->createCheckoutRegisterCustomerOrderSaver();

        $this->assertInstanceOf(RegisterCustomerOrderSaverInterface::class, $orderSaver);
    }

    /**
     * @return void
     */
    public function testCreateUpdateGuestCartOrderSaver(): void
    {
        $factory = new MimicCustomerAccountBusinessFactory();
        $orderSaver = $factory->createCheckoutUpdateGuestCartOrderSaver();

        $this->assertInstanceOf(UpdateGuestCartOrderSaverInterface::class, $orderSaver);
    }
}
