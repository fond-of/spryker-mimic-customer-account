<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Persistence;

interface MimicCustomerAccountEntityMangerInterface
{
    /**
     * @param string $uuid
     * @param string $customerRefrence
     *
     * @return bool
     */
    public function updateQuoteCustomerReference(string $uuid, string $customerRefrence): bool;
}
