<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountPersistenceFactory getFactory()
 */
class MimicCustomerAccountRepository extends AbstractRepository implements MimicCustomerAccountRepositoryInterface
{
    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomerByEmail(string $email): ?CustomerTransfer
    {
        $customerEntity = $this->getFactory()
            ->getCustomerQuery()
            ->findOneByEmail($email);

        if ($customerEntity === null) {
            return null;
        }

        $customerTransfer = new CustomerTransfer();

        return $customerTransfer->fromArray($customerEntity->toArray(), true);
    }

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
