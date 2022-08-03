<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Dependency\Facade;

use Generated\Shared\Transfer\CustomerTransfer;

interface MimicCustomerAccountToCustomerFacadeInterface
{
    /**
     * Specification:
     * - Validates customer password according configuration.
     * - Validates provided customer email information.
     * - Encrypts provided plain text password.
     * - Assigns current locale to customer if it is not set already.
     * - Generates customer reference for customer.
     * - Stores customer data.
     * - Sends registration confirmation link via email using a freshly generated registration key.
     * - Sends password restoration email if SendPasswordToken property is set in the provided transfer object.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function registerCustomer(CustomerTransfer $customerTransfer);
}
