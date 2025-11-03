# Changelog

All notable changes to `isyerim-pos` will be documented in this file.

## v1.0.1 - Bug Fixes and CI Improvements - 2025-11-03

### 🐛 Bug Fixes

- Fixed GitHub Actions workflow to work properly in CI environment
- Fixed ArchTest syntax for proper namespace checking
- Fixed PHPStan configuration to avoid false positives

### ⚡ Improvements

- Simplified test matrix (PHP 8.2, 8.3 with Laravel 11, 12)
- Improved package description and keywords for better discoverability
- Faster CI builds with optimized workflow

### 📦 Installation

  ```bash
  composer require apo-bozdag/isyerim-pos

  ```
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
