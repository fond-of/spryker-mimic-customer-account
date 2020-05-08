<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;

interface MimicCustomerAccountRepositoryInterface
{
    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomerByEmail(string $email): ?CustomerTransfer;

    /**
     * @param string $uuid
     * @param string $customerRefrence
     *
     * @return bool
     */
    public function updateQuoteCustomerReference(string $uuid, string $customerRefrence): bool;
}
