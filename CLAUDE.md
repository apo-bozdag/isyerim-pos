# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel package (`apo-bozdag/isyerim-pos`) that provides integration with the IsyerimPOS payment gateway API. IsyerimPOS is a Turkish payment gateway that supports:
- Virtual POS (Sanal POS) for online card payments with 3D Secure
- Physical POS device integration
- Marketplace/sub-merchant management (Pazaryeri)
- Wallet operations (Cüzdan)

The package follows Laravel package development best practices using Spatie's `laravel-package-tools`.

## Development Commands

### Testing
```bash
composer test                 # Run all tests with Pest
composer test-coverage        # Run tests with coverage report
vendor/bin/pest              # Direct Pest invocation
```

### Code Quality
```bash
composer analyse             # Run PHPStan static analysis (level 5)
composer format              # Format code with Laravel Pint
```

### Package Discovery
```bash
composer run prepare         # Discover packages (runs automatically after autoload dump)
```

### Running Single Tests
```bash
vendor/bin/pest tests/ExampleTest.php           # Run specific test file
vendor/bin/pest --filter="test_name"            # Run specific test by name
```

## Architecture

### Package Structure

- **Namespace**: `Abdullah\IsyerimPos`
- **Service Provider**: `IsyerimPosServiceProvider` - Registers config, views, migrations, and commands
- **Facade**: `IsyerimPos` facade available for static access
- **Main Class**: `IsyerimPos` - Currently empty, implementation pending

### Service Provider Registration

The package auto-registers via Laravel's package discovery:
- Config file: `config/isyerim-pos.php`
- Views: `resources/views/` (publishable)
- Migration: `database/migrations/create_isyerim_pos_table.php.stub`
- Command: `IsyerimPosCommand` (signature: `isyerim-pos`)

### API Integration Structure

Based on the Postman collection (`postman_collection.json`), the IsyerimPOS API has four main modules:

#### 1. SanalPOS API (Virtual POS)
Key endpoints:
- `getInstallments` - Get installment options for card
- `payRequest3d` - Initiate 3D Secure payment
- `payComplete` - Complete payment after 3D auth
- `payResultCheck` - Check payment result
- `commissions` - Get commission rates
- `cancelRequest` - Cancel transaction
- `refundRequest` - Refund transaction
- `transactions` - Get transaction report
- `createPayLink` - Create payment link

#### 2. POS Cihazı API (Physical POS Device)
- `terminals` - List POS devices
- `createCart` - Create cart/basket for POS
- `getCarts` - List carts
- Cart deletion endpoint

#### 3. Pazaryeri (Marketplace)
- `addSubmerchant` - Add/update sub-merchants
- `paymentStatus` - Check payment status
- `payments` - List payments
- `createToken` - Generate auth token

#### 4. Cüzdan (Wallet)
- `walletAccounts` - List wallet accounts
- `walletBalance` - Check balance
- `walletTransactions` - Transaction history
- `collectionRequest` - Money transfer/collection

### Authentication

API uses header-based authentication:
- `MerchantId` - Merchant identifier
- `UserId` - User identifier
- `ApiKey` - API authentication key

### Test Environment

Base URL: `https://apitest.isyerimpos.com/v1/`

## Implementation Guidelines

### When Adding New Features

1. The main implementation should go in `src/IsyerimPos.php`
2. Create dedicated service classes for each API module (e.g., `VirtualPosService`, `MarketplaceService`, `WalletService`)
3. Add configuration options to `config/isyerim-pos.php` for credentials and environment settings
4. Use Pest for testing with the existing `TestCase` base class
5. Follow PSR-4 autoloading: `Abdullah\IsyerimPos` namespace maps to `src/`

### Code Style

- PHP 8.4+ required
- Laravel 11.x or 12.x compatibility
- Use Laravel Pint for formatting (runs via `composer format`)
- PHPStan level 5 for static analysis
- Octane compatibility check enabled

### Testing

- Framework: Pest PHP 4.0
- Test namespace: `Abdullah\IsyerimPos\Tests`
- Base test case: `tests/TestCase.php` extends Orchestra Testbench
- Architecture tests available via Pest Arch plugin in `tests/ArchTest.php`

### Configuration Management

When adding new config values:
1. Update `config/isyerim-pos.php`
2. Document in README
3. Ensure publishable via `php artisan vendor:publish --tag="isyerim-pos-config"`

### Database Migrations

Migration stub located at: `database/migrations/create_isyerim_pos_table.php.stub`
Publishable via: `php artisan vendor:publish --tag="isyerim-pos-migrations"`

## PHP Version

Requires PHP ^8.4 - ensure type hints and modern PHP features are used appropriately.
