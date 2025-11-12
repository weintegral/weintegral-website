# Laravel 12 Upgrade Notes

## Overview
This document describes the upgrade from Laravel 11 to Laravel 12 and the updates to all associated PHP packages.

## Upgrade Date
November 12, 2025

## Laravel Version
- **Previous Version**: Laravel 11.x
- **Current Version**: Laravel 12.38.0

## PHP Version Requirement
- **Minimum**: PHP 8.2
- **Current**: PHP 8.3.6

## Updated Packages

### Laravel Core Packages
| Package | Previous Version | Updated Version |
|---------|-----------------|-----------------|
| laravel/framework | ^11.0 | 12.38.0 |
| laravel/sanctum | ^4.0 | 4.2.0 |
| laravel/tinker | ^2.7 | 2.10.1 |
| laravel/telescope | ^5.2 | 5.15.0 |
| laravel/pint | ^1.0 | 1.25.1 |
| laravel/sail | ^1.0.1 | 1.48.0 |

### Third-Party Packages
| Package | Previous Version | Updated Version |
|---------|-----------------|-----------------|
| guzzlehttp/guzzle | ^7.2 | 7.10.0 |
| orchid/platform | ^14.0 | 14.52.4 |
| phpunit/phpunit | ^11.0 | 11.5.43 |
| nunomaduro/collision | ^8.0 | 8.8.2 |
| spatie/laravel-ignition | ^2.0 | 2.9.1 |
| sentry/sentry-laravel | ^4.10 | 4.19.0 |
| opcodesio/log-viewer | ^3.0 | 3.21.1 |
| zircote/swagger-php | ^4.10 | 4.11.1 |

## Special Handling: sendportal-core

### Issue
The `mettle/sendportal-core` package (version 3.0.x) does not officially support Laravel 12 yet. The package constraint requires `illuminate/support: ^10.0|^11.0`.

### Solution
A local patch has been applied to make the package compatible with Laravel 12:

1. **Location**: `packages/sendportal-core/`
2. **Change**: Updated `composer.json` to accept `illuminate/support: ^10.0|^11.0|^12.0`
3. **Method**: Using a path repository in the main `composer.json`
4. **Version**: Using `dev-master` from the local path

### Configuration in composer.json
```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/sendportal-core"
        }
    ],
    "require": {
        "mettle/sendportal-core": "dev-master"
    }
}
```

## Security Verification

### Composer Audit
✅ **Status**: No security vulnerabilities found
```bash
composer audit
# Result: No security vulnerability advisories found.
```

### GitHub Advisory Database
✅ **Status**: All checked packages are secure
- guzzlehttp/guzzle 7.10.0
- laravel/framework 12.38.0
- laravel/sanctum 4.2.0
- laravel/tinker 2.10.1
- laravel/telescope 5.15.0
- phpunit/phpunit 11.5.43
- sentry/sentry-laravel 4.19.0
- spatie/laravel-ignition 2.9.1

## Testing

### PHPUnit Tests
✅ **Status**: All tests passing
```bash
php artisan test
# Result: Tests: 2, Assertions: 2
```

### Application Verification
✅ **Status**: Application boots successfully
```bash
php artisan --version
# Result: Laravel Framework 12.38.0

php artisan route:list
# Result: All routes loaded successfully
```

## Breaking Changes
Laravel 12 is a maintenance-focused release with minimal breaking changes. The upgrade was smooth with no code changes required in the application code.

## Future Considerations

### sendportal-core
Monitor the official `mettle/sendportal-core` repository for Laravel 12 support:
- Repository: https://github.com/mettle/sendportal-core
- Current official version: 3.0.2 (supports Laravel 10-11)
- When official support is released, update to remove the local patch

## Maintenance

### To update dependencies in the future:
```bash
composer update
composer audit
php artisan test
```

### To check for outdated packages:
```bash
composer outdated --direct
```

## References
- [Laravel 12 Release Notes](https://laravel.com/docs/12.x/releases)
- [Laravel 12 Upgrade Guide](https://laravel.com/docs/12.x/upgrade)
- [Laravel Version Support](https://laravelversions.com/)

## Support Timeline
- **Laravel 12 Release**: February 24, 2025
- **Bug Fixes Until**: August 13, 2026
- **Security Fixes Until**: February 24, 2027
