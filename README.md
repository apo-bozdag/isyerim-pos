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
