<?php

namespace FondOfSpryker\Zed\MimicCustomerAccount\Business\Checkout;

use FondOfSpryker\Zed\MimicCustomerAccount\Dependency\Facade\MimicCustomerAccountToCustomerFacadeInterface;
use FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

class ForceRegisterCustomerOrderSaver implements ForceRegisterCustomerOrderSaverInterface
{
    /**
     * @var array
     */
    public const GENDER_MAPPING = [
        'Mr' => 'Male',
        'Mrs' => 'Female',
        'Dr' => null,
        'Ms' => 'Female',
        'Diverse' => 'Diverse',
    ];

    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface
     */
    private $repository;

    /**
     * @var \FondOfSpryker\Zed\MimicCustomerAccount\Dependency\Facade\MimicCustomerAccountToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \FondOfSpryker\Zed\MimicCustomerAccount\Dependency\Facade\MimicCustomerAccountToCustomerFacadeInterface $customerFacade
     * @param \FondOfSpryker\Zed\MimicCustomerAccount\Persistence\MimicCustomerAccountRepositoryInterface $repository
     */
    public function __construct(MimicCustomerAccountToCustomerFacadeInterface $customerFacade, MimicCustomerAccountRepositoryInterface $repository)
    {
        $this->customerFacade = $customerFacade;
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
            $customerTransfer
                ->setIdCustomer($existingCustomer->getIdCustomer())
                ->setCustomerReference($existingCustomer->getCustomerReference());
        }

        $customerTransfer->setIsGuest(false);

        if ($customerTransfer->getIdCustomer() === null) {
            $customerTransfer->setDefaultBillingAddress($quoteTransfer->getBillingAddress());
            $customerTransfer->setDefaultShippingAddress($quoteTransfer->getShippingAddress());
            $customerTransfer->setGender($this->getGender($customerTransfer->getSalutation()));
            $customerTransfer->setPassword(sha1($this->generateRandomString()));
            $customerResponseTransfer = $this->customerFacade->registerCustomer($customerTransfer);
            $customerTransfer = $customerResponseTransfer->getCustomerTransfer();
            $quoteTransfer->setCustomer($customerTransfer);
        }
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
     * @param int $length
     *
     * @return string
     */
    protected function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * @param string|null $salutation
     *
     * @return string|null
     */
    protected function getGender(?string $salutation): ?string
    {
        if ($salutation === null || !isset(static::GENDER_MAPPING[$salutation])) {
            return null;
        }

        return static::GENDER_MAPPING[$salutation];
    }
}
