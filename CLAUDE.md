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
- **Interface**: `IsyerimPosInterface` - Contract for main service
- **Service Provider**: `IsyerimPosServiceProvider` - Registers interface binding and config
- **Facade**: `IsyerimPos` facade available for static access
- **Main Class**: `IsyerimPos implements IsyerimPosInterface` - Factory for service instances
- **HTTP Client**: `IsyerimPosClient` - Handles authentication and HTTP requests
- **Services**: Four service classes for different API modules
- **Exceptions**: Custom exception hierarchy for error handling

### Service Provider Registration

The package auto-registers via Laravel's package discovery:
- Config file: `config/isyerim-pos.php` (publishable)
- Interface binding: `IsyerimPosInterface::class` → singleton
- Alias: `IsyerimPos::class` → `IsyerimPosInterface::class`

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

- PHP 8.2+ required (supports PHP 8.2 and 8.3)
- Laravel 11.x or 12.x compatibility
- Use Laravel Pint for formatting (runs via `composer format`)
- PHPStan level 5 for static analysis (analyzes `src/` and `database/`, excludes `config/`)
- Octane compatibility check enabled

### Testing

- Framework: Pest PHP 3.x (v3.0 for PHP 8.2+ compatibility)
- Test namespace: `Abdullah\IsyerimPos\Tests`
- Base test case: `tests/TestCase.php` extends Orchestra Testbench
- Test credentials pre-configured in `getEnvironmentSetUp()` method
- Architecture tests available via Pest Arch plugin in `tests/ArchTest.php`
- CI runs tests on PHP 8.2 & 8.3 with Laravel 11 & 12

### Configuration Management

When adding new config values:
1. Update `config/isyerim-pos.php`
2. Document in README
3. Ensure publishable via `php artisan vendor:publish --tag="isyerim-pos-config"`

### Dependency Injection

The package uses interface-based dependency injection for flexibility and testability:

```php
// In your service providers or controllers
use Abdullah\IsyerimPos\Contracts\IsyerimPosInterface;

public function __construct(
    protected IsyerimPosInterface $isyerimPos
) {}

// Or use the concrete class (aliased to interface)
use Abdullah\IsyerimPos\IsyerimPos;

public function __construct(
    protected IsyerimPos $isyerimPos
) {}
```

The `IsyerimPosInterface` is bound as a singleton in the service container and aliased to the concrete `IsyerimPos` class for backward compatibility.

## Implementation Status

### ✅ Completed
- **Interface Contract** (`src/Contracts/IsyerimPosInterface.php`): Interface for dependency injection
- **HTTP Client** (`src/Client/IsyerimPosClient.php`): Authentication, retry mechanism, logging
- **Services** (all implemented):
  - `VirtualPosService`: 9 endpoints for online payments
  - `PhysicalPosService`: 4 endpoints for POS devices
  - `MarketplaceService`: 4 endpoints for sub-merchants
  - `WalletService`: 4 endpoints for wallet operations
- **Exceptions**: Complete hierarchy (`IsyerimPosException`, `AuthenticationException`, `PaymentException`, `ApiException`)
- **Main Class** (`IsyerimPos implements IsyerimPosInterface`): Factory pattern with lazy-loaded services
- **Service Provider**: Interface binding with singleton and alias for backward compatibility
- **Testing**: 7 tests with 11 assertions, all passing
- **CI/CD**: GitHub Actions with auto-update CHANGELOG

### 📋 Package Information
- **Current Version**: v1.0.3
- **Published**: https://packagist.org/packages/apo-bozdag/isyerim-pos
- **Requirements**: PHP ^8.2, Laravel ^11.0 || ^12.0

## Coding Standards

### Naming Conventions
- Use descriptive variable names
- Service methods follow API endpoint naming (camelCase)
- Configuration keys use snake_case
- Class names use PascalCase

### Error Handling
- Always throw specific exceptions from `src/Exceptions/`
- Use `AuthenticationException` for credential issues
- Use `PaymentException` for payment-specific errors
- Use `ApiException` for general API failures

### Documentation
- All public methods must have PHPDoc with parameter types
- Complex array parameters use PHPDoc shape syntax
- Include usage examples in method docblocks when helpful
