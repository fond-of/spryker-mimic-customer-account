<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountPersistenceFactory getFactory()
 */
class MimicCustomerAccountEntityManager extends AbstractEntityManager implements MimicCustomerAccountEntityMangerInterface
{
    /**
     * @param string $uuid
     * @param string $customerRefrence
     *
     * @return bool
     */
    public function updateQuoteCustomerReference(string $uuid, string $customerRefrence): bool
    {
        $quoteEntity = $this->getFactory()
            ->getQuoteQuery()
            ->findOneByUuid($uuid);

        if ($quoteEntity === null) {
            return false;
        }

        $quoteEntity->setCustomerReference($customerRefrence);
        $quoteEntity->save();

        return true;
    }
}
