# Changelog

All notable changes to `swisnl/phpstan-bitbucket` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](https://keepachangelog.com/) principles.

## [Unreleased]

### Changed

- Bumped minimum PHP version to 8.0.
- Report title is now simply "PHPStan".
- Moved several base classes to [swisnl/bitbucket-reports](https://github.com/swisnl/bitbucket-reports).


## [0.2.0] - 2022-11-04

This release lists changes compared to [alxt/phpstan-bitbucket:0.1.0](https://github.com/modprobe/phpstan-bitbucket/releases/tag/v0.1.0).

### Changed

- Bumped minimum PHP version to 7.4 and add support for PHP 8.
- Bumped dependencies.
- This error formatter will now also report errors using the default table error formatter.
- Changed package name to `swisnl/phpstan-bitbucket` and namespace to `Swis\PHPStan\ErrorFormatter`.
