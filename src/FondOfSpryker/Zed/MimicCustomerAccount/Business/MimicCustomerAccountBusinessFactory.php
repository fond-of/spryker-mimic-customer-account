<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business;

use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\ForceRegisterCustomerOrderSaver;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\ForceRegisterCustomerOrderSaverInterface;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaver;
use FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaverInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface getRepository()
 * @method \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountEntityMangerInterface getEntityManager()
 */
class MimicCustomerAccountBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\ForceRegisterCustomerOrderSaverInterface
     */
    public function createCheckoutForceRegisterCustomerOrderSaver(): ForceRegisterCustomerOrderSaverInterface
    {
        return new ForceRegisterCustomerOrderSaver(
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout\UpdateGuestCartOrderSaverInterface
     */
    public function createCheckoutUpdateGuestCartOrderSaver(): UpdateGuestCartOrderSaverInterface
    {
        return new UpdateGuestCartOrderSaver(
            $this->getEntityManager(),
        );
    }
}
