# Changelog

All notable changes to `isyerim-pos` will be documented in this file.

## v1.1.0 - API Response Enums - 2025-11-03

### 🎉 What's New

This release adds type-safe PHP enums for working with IsyerimPOS API response values.

#### ✨ New Features

##### PHP Enums (`src/Enums/`)

- **CardType** - Card classification (credit card, debit card, prepaid, etc.)
- **CardSchema** - Card networks (Visa, MasterCard, Troy, Amex, etc.)
- **CardBrand** - Turkish card programs (Bonus, Axess, Maximum, Paraf, World, etc.)
- **ProcessStatus** - Transaction lifecycle states with helper methods

##### Enum Features

- `label()` - Get human-readable names
- `tryFromValue()` - Safe value conversion (returns null on invalid values)
- **ProcessStatus helpers**: `isSuccessful()`, `isFailed()`, `isPending()`, `isFinal()`

#### 📖 Usage Example

  ```php
  use Abdullah\IsyerimPos\Enums\ProcessStatus;
use Abdullah\IsyerimPos\Facades\IsyerimPos;

$result = IsyerimPos::virtualPos()->payResultCheck(uid: 'xxx');

// Convert API integer value to enum
$status = ProcessStatus::tryFromValue($result['status']);

if ($status?->isSuccessful()) {
    echo "Payment successful: " . $status->label();
}

  ```
📚 Documentation

Complete enum documentation and API model descriptions added to README.

⚡ Backward Compatibility

All enums are 100% backward compatible and optional to use. Existing code will continue to work without any changes.

## v1.0.3 - Interface Pattern & Code Cleanup - 2025-11-03

### ♻️ Refactoring

Implemented interface-based dependency injection pattern and removed unused scaffold files for a cleaner package structure.

#### What's Changed

- ✨ **Added** `IsyerimPosInterface` contract for better dependency injection support
  
- 🔄 **Updated** `IsyerimPos` class to implement `IsyerimPosInterface`
  
- 🔧 **Updated** `IsyerimPosServiceProvider` to bind interface as singleton with alias
  
- 🗑️ **Removed** unused scaffold files:
  
  - `database/factories/ModelFactory.php`
  - `database/migrations/create_isyerim_pos_table.php.stub`
  - `resources/views/.gitkeep`
  - `src/Commands/IsyerimPosCommand.php`
  
- 🧹 **Removed** `hasViews()`, `hasMigration()`, `hasCommand()` from ServiceProvider
  
- 📦 **Cleaned** `composer.json` autoload configuration
  
- 🐛 **Fixed** PHPStan config to remove non-existent database path
  
- 📚 **Updated** CLAUDE.md with interface pattern documentation
  

#### Breaking Changes

✅ **None** - Fully backward compatible via container alias

#### Benefits

- 🧪 Better testability with interface-based dependency injection
- 🎯 Cleaner package structure without unused boilerplate
- ✨ Follows Laravel best practices for service container binding

#### Installation

  ```bash
  composer require apo-bozdag/isyerim-pos


  ```
Upgrade from v1.0.2

Simply update your composer dependencies:

  ```bash
  composer update apo-bozdag/isyerim-pos


  ```
Your existing code will continue to work without any changes.

## v1.0.2 - PHP 8.2 Compatibility Fix - 2025-11-03

### 🐛 Bug Fixes

Fixed PHP 8.2 compatibility by downgrading Pest test framework.

#### What Changed

- Downgraded `pestphp/pest` from v4.0 to v3.0 (Pest v4 requires PHP 8.3+)
- Downgraded `pestphp/pest-plugin-arch` from v4.0 to v3.0
- Downgraded `pestphp/pest-plugin-laravel` from v4.0 to v3.0

#### Compatibility

✅ PHP 8.2 and 8.3
✅ Laravel 11.x and 12.x
✅ All tests passing

### 📦 Installation

  ```bash
  composer require apo-bozdag/isyerim-pos



  ```
### 📚 Documentation

See [README.md](https://github.com/apo-bozdag/isyerim-pos#readme) for complete documentation.

### 🔄 Upgrade from v1.0.1

Simply update your composer dependencies:

  ```bash
  composer update apo-bozdag/isyerim-pos



  ```
## 1.0.2 - 2024-11-03

### Fixed

- Downgraded Pest to v3.x for PHP 8.2 compatibility (Pest v4 requires PHP 8.3+)
- Ensures package works on both PHP 8.2 and 8.3 with Laravel 11 & 12

### Changed

- Updated `pestphp/pest` from ^4.0 to ^3.0
- Updated `pestphp/pest-plugin-arch` from ^4.0 to ^3.0
- Updated `pestphp/pest-plugin-laravel` from ^4.0 to ^3.0

## 1.0.1 - 2024-11-03

### Fixed

- Fixed GitHub Actions workflow to work properly in CI environment
- Updated test matrix to use PHP 8.2 and 8.3 with prefer-stable only
- Fixed ArchTest syntax to use `toBeUsedIn()` method for proper namespace checking
- Excluded config directory from PHPStan analysis to avoid false positive env() warnings
- Removed Windows testing from CI to improve build speed

### Changed

- Simplified GitHub Actions test matrix for better CI performance
- Updated package description and keywords for better discoverability on Packagist

## 1.0.0 - 2024-11-03

### Added

#### Core Architecture

- Initial release of IsyerimPOS Laravel Package
- Complete integration with IsyerimPOS Payment Gateway API
- Main `IsyerimPos` class with service factory pattern
- Laravel Facade support for fluent API access
- Service Provider with singleton binding

#### Virtual POS Service

- `getInstallments()` - Get installment options for card payments
- `payRequest3d()` - Initiate 3D Secure payment transactions
- `payComplete()` - Complete 3D Secure payments
- `payResultCheck()` - Check payment transaction results
- `getCommissions()` - Retrieve commission rates
- `cancelRequest()` - Cancel payment transactions
- `refundRequest()` - Process full or partial refunds
- `getTransactions()` - Get transaction reports by date range
- `createPayLink()` - Generate payment links with SMS/Email support

#### Physical POS Service

- `getTerminals()` - List all POS terminals
- `createCart()` - Create shopping carts for POS devices
- `getCarts()` - Retrieve cart lists by terminal
- `deleteCart()` - Remove carts from POS devices

#### Marketplace Service

- `addSubMerchant()` - Add or update sub-merchant accounts
- `getPaymentStatus()` - Check marketplace payment status
- `getPayments()` - Get payment lists by date
- `createToken()` - Generate authentication tokens for users

#### Wallet Service

- `getWalletAccounts()` - List wallet accounts
- `getWalletBalance()` - Check wallet balance
- `getWalletTransactions()` - Get transaction history
- `collectionRequest()` - Request money transfers

#### HTTP Client

- Custom HTTP client with authentication headers (MerchantId, UserId, ApiKey)
- Automatic retry mechanism with configurable attempts
- Request/Response logging support
- Timeout configuration
- Error handling with proper HTTP status codes

#### Exception Handling

- `IsyerimPosException` - Base exception class
- `AuthenticationException` - Invalid or missing credentials
- `PaymentException` - Payment-specific errors
- `ApiException` - API request/response errors

#### Configuration

- Comprehensive configuration file with environment variable support
- Test and production URL switching
- Configurable timeouts and retry settings
- Optional logging with channel selection
- Request/Response logging toggles

#### Testing

- Complete test suite with Pest PHP
- TestCase with pre-configured credentials
- Architecture tests for code quality
- 7 passing tests with 12 assertions

#### Documentation

- Comprehensive README with usage examples
- CLAUDE.md for AI-assisted development
- PHPDoc annotations for all public methods
- Installation and configuration guides
- Error handling examples
- Code examples for all services

### Requirements

- PHP ^8.2
- Laravel ^11.0 || ^12.0
- illuminate/contracts ^11.0 || ^12.0
- spatie/laravel-package-tools ^1.16
