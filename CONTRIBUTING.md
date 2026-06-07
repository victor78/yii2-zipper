# Contributing to Yii2-Zipper

Thank you for considering contributing to Yii2-Zipper!

## Development Setup

1. Clone the repository:
```bash
git clone https://github.com/victor78/yii2-zipper.git
cd yii2-zipper
```

2. Configure the Yii2 asset repository and allow its Composer plugin
   (required to install the Yii2 test stack):
```bash
composer config repositories.asset-packagist composer https://asset-packagist.org
composer config --no-plugins allow-plugins.yiisoft/yii2-composer true
```

3. Install dependencies:
```bash
composer install
```

4. Install 7zip (required for 7zip adapter tests):
```bash
# Ubuntu/Debian
sudo apt-get install p7zip-full

# macOS
brew install sevenzip
```

5. Run tests:
```bash
vendor/bin/phpunit
```

## Requirements

- PHP 8.1+
- Composer
- Yii2 framework (pulled in as a dependency)
- 7-Zip (`7za` or `7z` in PATH) for running 7zip adapter tests

## Branching

- `master` — stable releases
- `release/1.x` — current development branch

## Submitting Changes

1. Fork the repository
2. Create a feature branch from `master`
3. Make your changes with tests
4. Ensure all tests pass: `vendor/bin/phpunit`
5. Submit a Pull Request to `master`

## Coding Standards

- PHP 8.1+ syntax
- `declare(strict_types=1)` in all source files
- PSR-4 autoloading
- PHPDoc for public methods
