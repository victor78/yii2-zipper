<?php

declare(strict_types=1);

namespace Victor78\Zipper;

use Alchemy\Zippy\Archive\ArchiveInterface;

/**
 * Interface for victor78/yii2-zipper compliant archiveMaker.
 */
interface ZipperInterface
{
    public function create(
        string $path,
        ?array $files = null,
        bool $recursive = true,
        ?string $type = null,
        ?string $password = null
    ): ArchiveInterface;

    public function open(
        string $path,
        ?string $type = null,
        ?string $password = null
    ): ArchiveInterface;

    public function setType(string $type): void;

    public function setExt(string $ext): void;

    public function setPassword(string $password): void;
}
