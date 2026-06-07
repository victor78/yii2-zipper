<?php

declare(strict_types=1);

namespace Victor78\Zipper;

use yii\base\Component;

use Alchemy\Zippy\Archive\ArchiveInterface;
use Victor78\ZippyExt\Zippy;

class Zipper extends Component implements ZipperInterface
{
    protected Zippy $zippy;
    public string $type = 'zip';
    public ?string $ext = null;
    public ?string $password = null;

    public function init(): void
    {
        parent::init();
        $this->zippy = Zippy::load();
        $this->ext ??= $this->type === '7zip' ? 'zip' : $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setExt(string $ext): void
    {
        $this->ext = $ext;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function create(
        string $path,
        ?array $files = null,
        bool $recursive = true,
        ?string $type = null,
        ?string $password = null
    ): ArchiveInterface {
        return $this->zippy->create(
            $path,
            $files,
            $recursive,
            $type ?: $this->type,
            $password ?: $this->password
        );
    }

    public function open(
        string $path,
        ?string $type = null,
        ?string $password = null
    ): ArchiveInterface {
        return $this->zippy->open(
            $path,
            $type ?: $this->type,
            $password ?: $this->password
        );
    }

    public function getInflatorVersion(?string $type = null): mixed
    {
        $type ??= $this->type;

        return $this->zippy->getAdapterFor($type)->getInflatorVersion();
    }

    public function getDeflatorVersion(?string $type = null): mixed
    {
        $type ??= $this->type;

        return $this->zippy->getAdapterFor($type)->getDeflatorVersion();
    }
}
