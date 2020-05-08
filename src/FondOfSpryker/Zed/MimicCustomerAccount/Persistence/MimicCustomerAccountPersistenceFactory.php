<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Persistence;

use FondOfSpryker\Zed\MimicCustomerAccount\MimicCustomerAccountDependencyProvider;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\Quote\Persistence\SpyQuoteQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface getRepository()
 */
class MimicCustomerAccountPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(MimicCustomerAccountDependencyProvider::PROPEL_QUERY_CUSTOMER);
    }

    /**
     * @return \Orm\Zed\Quote\Persistence\SpyQuoteQuery
     */
    public function getQuoteQuery(): SpyQuoteQuery
    {
        return $this->getProvidedDependency(MimicCustomerAccountDependencyProvider::PROPEL_QUERY_QUOTE);
    }
}
