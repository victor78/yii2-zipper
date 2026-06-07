# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] — 2026-06-07

### Changed
- Minimum PHP version raised to `8.1`.
- Upgraded `victor78/zippy-ext` dependency to `^1.0` (was `~0.0.4`).
- `src/Zipper.php` and `src/ZipperInterface.php` modernized for PHP 8.1:
  `declare(strict_types=1)`, typed properties, explicit nullable parameters
  (`?array` / `?string`), and return types (`ArchiveInterface`, `void`).
- `Zipper::init()` now calls `parent::init()` to keep the Yii2 component lifecycle intact.
- `Zipper::$zippy` is now a non-nullable typed property (set in `init()`), removing
  the false "possibly null" signal for static analysis.
- `yiisoft/yii2` constraint tightened from `*` to `~2.0.45` (first line with PHP 8.1 support).

### Added
- `ZipperInterface::open()` — the read counterpart of `create()` is now part of the contract.
- `phpunit/phpunit ^10.5` in `require-dev`.
- CI workflow (`.github/workflows/ci.yml`) with a PHP 8.1/8.2/8.3 matrix,
  `7zip` installation and `asset-packagist` setup for the Yii2 test stack.
- `CHANGELOG.md`, `CONTRIBUTING.md` and `SECURITY.md`.

### Fixed
- Removed the hardcoded `"version"` field from `composer.json` (Packagist reads git tags).
- Test suite migrated to PHPUnit 10:
  - `setUp(): void` / `tearDown(): void`, initialization moved out of `__construct`;
  - archive type checks switched from `assertSame(get_class(...), Archive::class)` to
    `assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, ...)` — the 7zip
    adapter in ZippyExt 1.x returns `Victor78\ZippyExt\Archive\Archive`;
  - `testGetVersion` no longer requires a numeric version for non-7zip adapters;
  - `phpunit.xml` migrated to the PHPUnit 10 schema (`<source>` instead of `<filter>`);
  - `FileHelper` now auto-creates test arena directories;
  - `7za`/`7z` availability is detected and the 7zip suite is skipped when absent.
- Renamed `tests/unit/ZipperZipTes.php` to `ZipperZipTest.php` so PHPUnit discovers it.

### Documentation
- README updated: install constraint `^1.0`, PHP compatibility table,
  requirements now mention both `7za` and `7z`, and assorted typo fixes.

## [0.0.4] — (previous release)

- Archiving component for Yii2 over ZippyExt: zip, tar, tar.gz, tar.bz2 and 7zip
  (zip archive with optional password support).

[Unreleased]: https://github.com/victor78/yii2-zipper/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/victor78/yii2-zipper/compare/0.0.4...v1.0.0
[0.0.4]: https://github.com/victor78/yii2-zipper/releases/tag/0.0.4
