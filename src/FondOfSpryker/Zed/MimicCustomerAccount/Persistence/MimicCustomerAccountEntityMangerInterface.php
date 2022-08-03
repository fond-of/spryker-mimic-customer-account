<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Persistence;

interface MimicCustomerAccountEntityMangerInterface
{
    /**
     * @param string $uuid
     * @param string $customerReference
     *
     * @return bool
     */
    public function updateQuoteCustomerReference(string $uuid, string $customerReference): bool;
}
