# IsyerimPOS Laravel Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/apo-bozdag/isyerim-pos.svg?style=flat-square)](https://packagist.org/packages/apo-bozdag/isyerim-pos)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/apo-bozdag/isyerim-pos/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/apo-bozdag/isyerim-pos/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/apo-bozdag/isyerim-pos/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/apo-bozdag/isyerim-pos/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/apo-bozdag/isyerim-pos.svg?style=flat-square)](https://packagist.org/packages/apo-bozdag/isyerim-pos)

A comprehensive Laravel package for integrating with IsyerimPOS payment gateway API. This package provides a clean, fluent interface for processing payments, managing POS devices, marketplace operations, and wallet transactions.

## Features

- **Virtual POS (Sanal POS)**: Process online card payments with 3D Secure support
- **Physical POS Devices**: Manage and create carts for physical POS terminals
- **Marketplace**: Sub-merchant management and payment distribution
- **Wallet Operations**: Account management, balance checks, and money transfers
- **Comprehensive Error Handling**: Custom exceptions for better debugging
- **Logging Support**: Optional request/response logging
- **Test Mode**: Built-in support for test environment

## Installation

Install the package via composer:

```bash
composer require apo-bozdag/isyerim-pos
```

Publish the config file:

```bash
php artisan vendor:publish --tag="isyerim-pos-config"
```

## Configuration

Add your IsyerimPOS credentials to your `.env` file:

```env
ISYERIMPOS_MERCHANT_ID=your-merchant-id
ISYERIMPOS_USER_ID=your-user-id
ISYERIMPOS_API_KEY=your-api-key

# Optional: Set to production URL when going live
ISYERIMPOS_BASE_URL=https://apitest.isyerimpos.com/v1/

# Optional: Enable logging for debugging
ISYERIMPOS_LOGGING=true
```

## Usage

### Virtual POS (Sanal POS)

#### Get Installment Options

```php
use Abdullah\IsyerimPos\Facades\IsyerimPos;

$installments = IsyerimPos::virtualPos()->getInstallments(
    cardNumber: '5818775818772285',
    amount: 100.00,
    reflectCost: true
);
```

#### 3D Secure Payment

```php
$payment = IsyerimPos::virtualPos()->payRequest3d([
    'ReturnUrl' => 'https://yoursite.com/payment/callback',
    'OrderId' => 'ORDER-123456',
    'ClientIp' => request()->ip(),
    'Installment' => 1,
    'Amount' => 100.00,
    'Is3D' => true,
    'IsAutoCommit' => false,
    'CardInfo' => [
        'CardOwner' => 'JOHN DOE',
        'CardNo' => '5818775818772285',
        'Month' => '12',
        'Year' => '26',
        'Cvv' => '123',
    ],
    'CustomerInfo' => [
        'Name' => 'John Doe',
        'Phone' => '5301234567',
        'Email' => 'john@example.com',
        'Address' => 'Sample Address',
        'Description' => 'Payment for order #123',
    ],
    'Products' => [
        [
            'Name' => 'Product 1',
            'Count' => 1,
            'UnitPrice' => 100.00,
        ],
    ],
]);

// Redirect user to 3D Secure page
return redirect($payment['redirectUrl']);
```

#### Complete Payment

```php
$result = IsyerimPos::virtualPos()->payComplete(
    uid: $request->uid,
    key: $request->key
);
```

#### Check Payment Result

```php
$status = IsyerimPos::virtualPos()->payResultCheck(uid: 'transaction-uid');
```

#### Cancel/Refund Transactions

```php
// Cancel
$cancel = IsyerimPos::virtualPos()->cancelRequest(
    uid: 'transaction-uid',
    description: 'Customer requested cancellation'
);

// Refund (full or partial)
$refund = IsyerimPos::virtualPos()->refundRequest(
    uid: 'transaction-uid',
    amount: 50.00, // 0 for full refund
    description: 'Partial refund'
);
```

#### Create Payment Link

```php
$paymentLink = IsyerimPos::virtualPos()->createPayLink([
    'LifeTime' => 15, // minutes
    'Amount' => 100.00,
    'ReturnUrl' => 'https://yoursite.com/payment/return',
    'InstallmentActive' => false,
    'Description' => 'Payment for Order #123',
    'SendSms' => true,
    'SendMail' => true,
    'Customer' => [
        'Name' => 'John',
        'Surname' => 'Doe',
        'Phone' => '5301234567',
        'Email' => 'john@example.com',
    ],
    'Products' => [
        [
            'Name' => 'Product 1',
            'Count' => 1,
            'UnitPrice' => 100.00,
        ],
    ],
]);
```

### Physical POS Service

```php
// Get terminals
$terminals = IsyerimPos::physicalPos()->getTerminals();

// Create cart
$cart = IsyerimPos::physicalPos()->createCart([
    'Name' => 'TABLE-1',
    'TerminalId' => '12345678',
    'Direct' => true,
    'PaymentType' => 0, // 0: credit card, 1: cash
    'Items' => [
        [
            'Count' => 1,
            'Name' => 'Product Name',
            'TaxValue' => 18,
            'UnitPrice' => 100.00,
        ],
    ],
]);

// Get carts
$carts = IsyerimPos::physicalPos()->getCarts(tid: '12345678');
```

### Marketplace Service

```php
// Add sub-merchant
$subMerchant = IsyerimPos::marketplace()->addSubMerchant([
    'CreateUser' => true,
    'companyName' => 'Demo Company Ltd.',
    'shopName' => 'Demo Shop',
    'authorizedPerson' => 'John Doe',
    'tcIdentityNumber' => '12345678901',
    'taxNumber' => '1234567890',
    'taxOffice' => 'Kadıköy',
    'email' => 'shop@example.com',
    'gsmNumber' => '5301234567',
    'iban' => 'TR000000000000000000000000',
    'accountOwner' => 'Demo Company',
    'province' => 'Istanbul',
    'provinceCode' => 34,
    'valor' => 10,
    'PaymentDay' => 5,
]);

// Get payment status
$status = IsyerimPos::marketplace()->getPaymentStatus(uid: 'payment-uid');

// Get payments for date
$payments = IsyerimPos::marketplace()->getPayments(date: '2024-01-15');
```

### Wallet Service

```php
// Get wallet accounts
$accounts = IsyerimPos::wallet()->getWalletAccounts();

// Get balance
$balance = IsyerimPos::wallet()->getWalletBalance(walletId: 12345);

// Get transactions
$transactions = IsyerimPos::wallet()->getWalletTransactions(
    startDate: '2024-01-01',
    endDate: '2024-01-31',
    walletId: 12345
);

// Collection request
$collection = IsyerimPos::wallet()->collectionRequest([
    'identityNo' => '12345678901',
    'amount' => 100.00,
    'url' => 'https://yoursite.com/webhook',
]);
```

## API Models & Enums

The package provides PHP enums for working with IsyerimPOS API responses. These enums offer type-safe handling of API values with helpful utility methods.

### Available Enums

#### CardType

Card classification enum (`Abdullah\IsyerimPos\Enums\CardType`):

```php
use Abdullah\IsyerimPos\Enums\CardType;

CardType::UNDEFINED        // 0
CardType::CREDIT_CARD      // 1
CardType::DEBIT_CARD       // 2
CardType::ACQUIRING        // 3
CardType::PREPAID          // 4

// Usage example
$cardType = CardType::tryFromValue($apiResponse['cardType']);
echo $cardType->label(); // "Credit Card"
```

#### CardSchema

Card network/scheme enum (`Abdullah\IsyerimPos\Enums\CardSchema`):

```php
use Abdullah\IsyerimPos\Enums\CardSchema;

CardSchema::UNDEFINED             // 0
CardSchema::VISA                  // 1
CardSchema::MASTERCARD            // 2
CardSchema::AMEX                  // 3
CardSchema::DINERS_CLUB           // 4
CardSchema::JCB                   // 5
CardSchema::TROY                  // 6
CardSchema::UNION_PAY             // 7
CardSchema::PROPRIETARY_DOMESTIC  // 8

// Usage example
$schema = CardSchema::tryFromValue($apiResponse['cardSchema']);
echo $schema->label(); // "Visa"
```

#### CardBrand

Turkish card programs enum (`Abdullah\IsyerimPos\Enums\CardBrand`):

```php
use Abdullah\IsyerimPos\Enums\CardBrand;

CardBrand::UNDEFINED      // 0
CardBrand::ADVANTAGE      // 1
CardBrand::AXESS          // 2
CardBrand::BONUS          // 3
CardBrand::MAXIMUM        // 6
CardBrand::PARAF          // 7
CardBrand::WORLD          // 8
// ... and more (18 total brands)

// Usage example
$brand = CardBrand::tryFromValue($apiResponse['cardBrand']);
echo $brand->label(); // "Bonus"
```

#### ProcessStatus

Transaction lifecycle state enum (`Abdullah\IsyerimPos\Enums\ProcessStatus`):

```php
use Abdullah\IsyerimPos\Enums\ProcessStatus;

ProcessStatus::UNDEFINED                  // 0
ProcessStatus::PENDING                    // 1
ProcessStatus::VERIFIED                   // 2
ProcessStatus::SUCCESSFUL                 // 4
ProcessStatus::FAILED                     // 5
ProcessStatus::CANCELLED                  // 6
ProcessStatus::CANCELLATION_IN_PROGRESS   // 7
ProcessStatus::REFUND_IN_PROGRESS         // 8
ProcessStatus::CHARGEBACK_IN_PROGRESS     // 9
ProcessStatus::RISKY                      // 10

// Usage example with helper methods
$status = ProcessStatus::tryFromValue($apiResponse['status']);

if ($status->isSuccessful()) {
    // Payment completed successfully
}

if ($status->isPending()) {
    // Payment is still processing
}

if ($status->isFinal()) {
    // Payment reached a final state (successful, failed, or cancelled)
}

echo $status->label(); // "Successful"
```

### API Response Models

The IsyerimPOS API returns standardized response models:

#### Result/Pay Model
Standard response wrapper containing:
- Operation completion status
- Success/error messages
- Error codes and error collections
- Additional response data

#### CardInfo Model
Payment card information:
- Cardholder name
- Card number
- Expiration month/year
- CVV security code

#### CustomerInfo Model
Customer details:
- Name and email
- Physical address
- Phone number
- Optional description/notes

#### Product Model
Line item information:
- Product name
- Quantity count
- Per-unit pricing

#### Payment Model
Transfer/payment details:
- Account holder name
- IBAN
- Payment description
- Amount
- Sub-merchant identifier
- External customer reference

For complete model definitions and additional details, see the [official API documentation](https://dev.isyerimpos.com/modeller).

## Error Handling

The package throws specific exceptions for different error scenarios:

```php
use Abdullah\IsyerimPos\Exceptions\PaymentException;
use Abdullah\IsyerimPos\Exceptions\ApiException;
use Abdullah\IsyerimPos\Exceptions\AuthenticationException;

try {
    $payment = IsyerimPos::virtualPos()->payRequest3d($data);
} catch (AuthenticationException $e) {
    // Handle authentication errors (invalid credentials)
} catch (PaymentException $e) {
    // Handle payment-specific errors
} catch (ApiException $e) {
    // Handle API errors
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Abdullah Bozdağ](https://github.com/apo-bozdag)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
