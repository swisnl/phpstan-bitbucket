# PHPStan Bitbucket error formatter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

This PHPStan error formatter will add annotations in Bitbucket, for example in pull requests, similar to the built-in GitHub formatting.

## Installation

Via Composer

```bash
composer require --dev alxt/phpstan-bitbucket
```

If you also have [phpstan/extension-installer](https://github.com/phpstan/extension-installer) installed, then you're all set!

<details>
  <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include extension.neon in your project's PHPStan config:

```neon
includes:
    - vendor/alxt/phpstan-bitbucket/extension.neon
```
</details>

## Usage

To use this custom error formatter you need to run PHPStan with `--error-format=bitbucket` option. For example:
```shell
vendor/bin/phpstan analyse src -l8 --error-format=bitbucket
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Alexander Timmermann][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/alxt/phpstan-bitbucket.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/alxt/phpstan-bitbucket.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/alxt/phpstan-bitbucket
[link-downloads]: https://packagist.org/packages/alxt/phpstan-bitbucket
[link-author]: https://github.com/modprobe
[link-contributors]: ../../contributors
