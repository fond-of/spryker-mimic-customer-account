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
     * @param string $customerReference
     *
     * @return bool
     */
    public function updateQuoteCustomerReference(string $uuid, string $customerReference): bool
    {
        $query = $this->getFactory()
            ->getQuoteQuery();
        $quoteEntity = $query
            ->filterByUuid($uuid)
            ->findOne();

        if ($quoteEntity === null) {
            return false;
        }

        $quoteEntity->setCustomerReference($customerReference);
        $quoteEntity->save();

        return true;
    }
}
