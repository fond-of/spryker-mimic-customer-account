<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business;

use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\RegisterCustomerOrderSaver;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\RegisterCustomerOrderSaverInterface;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaver;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaverInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class MimicCustomerAccountBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\RegisterCustomerOrderSaverInterface
     */
    public function createCheckoutRegisterCustomerOrderSaver(): RegisterCustomerOrderSaverInterface
    {
        return new RegisterCustomerOrderSaver();
    }

    /**
     * @return \FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaverInterface
     */
    public function createCheckoutUpdateGuestCartOrderSaver(): UpdateGuestCartOrderSaverInterface
    {
        return new UpdateGuestCartOrderSaver();
    }
}
