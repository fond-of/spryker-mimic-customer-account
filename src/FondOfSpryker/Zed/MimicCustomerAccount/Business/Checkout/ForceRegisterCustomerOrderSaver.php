<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout;

use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

class ForceRegisterCustomerOrderSaver implements ForceRegisterCustomerOrderSaverInterface
{
    /**
     * @var array<string,string>
     */
    public const GENDER_MAPPING = [
        'male' => 'Male',
        'female' => 'Female',
        'unknown' => null,
        'diverse' => 'Diverse',
    ];

    /**
     * @var array<string,string>
     */
    public const SALUTATION_TO_GENDER_MAPPING = [
        'Mr' => 'male',
        'Ms' => 'female',
        'Mrs' => 'female',
        'Dr' => 'unknown',
        'Diverse' => 'diverse',
    ];

    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface
     */
    private $repository;

    /**
     * @param \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface $repository
     */
    public function __construct(MimicCustomerAccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrderForceRegisterCustomer(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void
    {
        $customerTransfer = $quoteTransfer->getCustomer();

        $customerTransfer->requireEmail();

        $existingCustomer = $this->getCustomerByEmail($customerTransfer->getEmail());
        if ($existingCustomer !== null) {
            $existingCustomer = $this->updateExistingCustomer($existingCustomer, $quoteTransfer->getBillingAddress());

            $customerTransfer->fromArray($existingCustomer->toArray());
        }

        $customerTransfer->setIsGuest(false);
        $customerTransfer->setForcedRegister(true);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $existingCustomer
     * @param \Generated\Shared\Transfer\AddressTransfer $billingAddress
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function updateExistingCustomer(CustomerTransfer $existingCustomer, AddressTransfer $billingAddress): CustomerTransfer
    {
        if ($existingCustomer->getFirstName() === null) {
            $existingCustomer->setFirstName($billingAddress->getFirstName());
        }

        if ($existingCustomer->getLastName() === null) {
            $existingCustomer->setLastName($billingAddress->getLastName());
        }

        if ($existingCustomer->getSalutation() === null) {
            $existingCustomer->setSalutation($this->getSalutation($billingAddress->getSalutation()));
        }

        if ($existingCustomer->getGender() === null) {
            $existingCustomer->setGender($this->getGender($this->getGenderBySalutation($billingAddress->getSalutation())));
        }

        if ($existingCustomer->getPhone() === null) {
            $existingCustomer->setPhone($billingAddress->getPhone());
        }

        return $existingCustomer;
    }

    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function getCustomerByEmail(string $email): ?CustomerTransfer
    {
        $customerTransfer = $this->repository->getCustomerByEmail($email);

        if ($customerTransfer === null) {
            return null;
        }

        return $customerTransfer;
    }

    /**
     * @param string|null $salutation
     *
     * @return string|null
     */
    protected function getGenderBySalutation(?string $salutation): ?string
    {
        if (array_key_exists(ucfirst(strtolower($salutation)), static::SALUTATION_TO_GENDER_MAPPING)) {
            return self::SALUTATION_TO_GENDER_MAPPING[ucfirst(strtolower($salutation))];
        }

        return null;
    }

    /**
     * @param string|null $gender
     *
     * @return string|null
     */
    protected function getGender(?string $gender): ?string
    {
        if (array_key_exists(strtolower($gender), static::GENDER_MAPPING)) {
            return static::GENDER_MAPPING[strtolower($gender)];
        }

        return null;
    }

    /**
     * @param string|null $salutation
     *
     * @return string|null
     */
    protected function getSalutation(?string $salutation): ?string
    {
        $salutation = ucfirst(strtolower($salutation));
        if (array_key_exists($salutation, static::SALUTATION_TO_GENDER_MAPPING)) {
            return $salutation;
        }

        return null;
    }
}
