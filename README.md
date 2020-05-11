# Spryker Mimic Customer Account

This Spryker package allows to create environments where users don't log in but customer accounts exist.
The package contains two `CheckoutDoSaveOrder` plugins to support that functionality.

One plugin is used to force the customer to register in the background and the other will update anonymous quotes when orders are done via rest-api.

## Installation

```
composer require fond-of-spryker/mimic-customer-account
```

## Plugin Structure

### ForceRegisterCustomerOrderSavePlugin
Specification:
* Check if customer already exists in database
* Update customer transfer with existing id and reference
* Force isGuest to be false

The plugin needs to be initialized in your CheckoutDepenendcyProvider _**before**_ the CustomerOrderSavePlugin.

### UpdateGuestCartOrderSavePlugin
Specification:
* Validate if the quote is anonymous
* Update customer reference for quote identified by uuid
* Update quote transfer if quote has been updated

The plugin should be initialized in your CheckoutDepenendcyProvider _**after**_ the CustomerOrderSavePlugin.
