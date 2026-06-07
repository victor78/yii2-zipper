<?php

namespace tests\unit;

require_once 'FileHelper.php';

use Yii;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\ExecutableFinder;

class ZipperTesting extends TestCase
{
    const PASSWORD = "12321";
    public $fileHelper;
    public $zipper;
    public $ext = 'zip';
    public $type = 'zip';

    protected function setUp(): void
    {
        if ($this->fileHelper === null) {
            $this->fileHelper = FileHelper::create();
        }

        $this->zipper = Yii::$app->zipper;
        $this->zipper->setType($this->type);

        if ($this->type === '7zip' && !$this->has7zipBinary()) {
            $this->markTestSkipped('7zip binary (7za/7z) is not available in PATH.');
        }

        $this->fileHelper->fillArena();
    }

    protected function tearDown(): void
    {
        $this->fileHelper->clearArena();
        $this->fileHelper->clearArchiveArena();
    }


    public function testCreateArchLevel1Files()
    {
        $zippy = $this->zipper;

        $files = $this->fileHelper->getLevelItems(1);
        $archiveFile = $this->fileHelper->archiveDir.'/archive1.'.$this->ext;

        $archiveZip = $zippy->create($archiveFile, $files, true, $this->type);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);

        $isArchiveExists = file_exists($archiveFile);
        $this->assertTrue($isArchiveExists);
    }

    public function testCreateArchLevel01Files()
    {
        $zippy = $this->zipper;

        $files0 = $this->fileHelper->getLevelItems(0);
        $files1 = $this->fileHelper->getLevelItems(1);
        $files = array_merge($files0, $files1);
        $configFiles = [];
        foreach ($files as $file){
            $configFiles[str_replace($this->fileHelper->arenaDir.'/', '', $file)] = $file;
        }

        $archiveFile = $this->fileHelper->archiveDir.'/archive01.'.$this->ext;

        $archiveZip = $zippy->create($archiveFile, $configFiles, true, $this->type);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);

        $isArchiveExists = file_exists($archiveFile);
        $this->assertTrue($isArchiveExists);
    }


    public function testCreateArchLevel2Files()
    {
        $zippy = $this->zipper;

        $files = $this->fileHelper->getLevelItems(2);
        $archiveFile = $this->fileHelper->archiveDir.'/archive2.'.$this->ext;

        $archiveZip = $zippy->create($archiveFile, $files, true, $this->type);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);

        $isArchiveExists = file_exists($archiveFile);
        $this->assertTrue($isArchiveExists);
    }

    public function testCreateArchAllFiles()
    {
        $zippy = $this->zipper;

        $files = $this->fileHelper->getLevelItems(0, 1, 1);
        $archiveFile = $this->fileHelper->archiveDir.'/archive_all.'.$this->ext;

        $archiveZip = $zippy->create($archiveFile, $files, true, $this->type);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);

        $isArchiveExists = file_exists($archiveFile);
        $this->assertTrue($isArchiveExists);
    }

    public function testCreateArchAllFilesWithPassword()
    {
        $zippy = $this->zipper;

        $files = $this->fileHelper->getLevelItems(0, 1, 1);
        $archiveFile = $this->fileHelper->archiveDir.'/archive_all_pwd.'.$this->ext;

        $archiveZip = $zippy->create($archiveFile, $files, true, $this->type, self::PASSWORD);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);

        $isArchiveExists = file_exists($archiveFile);
        $this->assertTrue($isArchiveExists);
    }

    public function testAddMembers()
    {
        $zippy = $this->zipper;

        $rootFiles = $this->fileHelper->getLevelItems();
        $archiveFile = $this->fileHelper->archiveDir.'/archive_add.'.$this->ext;

        $archiveZip = $zippy->create($archiveFile, $rootFiles, true, $this->type);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);

        $isArchiveExists = file_exists($archiveFile);
        $this->assertTrue($isArchiveExists);

        $addedFile = $this->fileHelper->getAddedFile();
        $archiveZip->addMembers([$addedFile]);
    }

    public function testAddMembersWithPassword()
    {
        $zippy = $this->zipper;

        $rootFiles = $this->fileHelper->getLevelItems();
        $archiveFile = $this->fileHelper->archiveDir.'/archive_add_pwd.'.$this->ext;

        $archiveZip = $zippy->create($archiveFile, $rootFiles, true, $this->type, self::PASSWORD);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);

        $isArchiveExists = file_exists($archiveFile);
        $this->assertTrue($isArchiveExists);

        $addedFile = $this->fileHelper->getAddedFile();
        $archiveZip->addMembers([$addedFile]);
    }

    public function testRemoveMembersWithPassword()
    {
        $zippy = $this->zipper;
        $archiveSource = $this->fileHelper->assetsDir.'/add/archive_add_pwd.'.$this->ext;
        $archiveDest = $this->fileHelper->archiveDir.'/archive_add_pwd_removing.'.$this->ext;
        copy($archiveSource, $archiveDest);
        $archiveZip = $zippy->open($archiveDest, $this->type, self::PASSWORD);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);
        $members = $archiveZip->getMembers();
        $countMembersBegin = count($members);
        $this->assertGreaterThan(0, $countMembersBegin, 'Количество членов должно быть больше 0');
        $member = $members[0];
        $removedFiles = $archiveZip->removeMembers($member->getLocation());
        $newMembers = $archiveZip->getMembers();
        $countMembersEnd = count($newMembers);

        $this->assertNotSame($countMembersBegin, $countMembersEnd);

    }

    public function testRemoveMembersWithoutPassword()
    {
        $zippy = $this->zipper;
        $archiveSource = $this->fileHelper->assetsDir.'/add/archive_add.'.$this->ext;
        $archiveDest = $this->fileHelper->archiveDir.'/archive_add_removing.'.$this->ext;
        copy($archiveSource, $archiveDest);
        $archiveZip = $zippy->open($archiveDest, $this->type);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);
        $members = $archiveZip->getMembers();
        $countMembersBegin = count($members);
        $this->assertGreaterThan(0, $countMembersBegin, 'Количество членов должно быть больше 0');
        $member = $members[0];
        $removedFiles = $archiveZip->removeMembers($member->getLocation());
        $newMembers = $archiveZip->getMembers();
        $countMembersEnd = count($newMembers);

        $this->assertNotSame($countMembersBegin, $countMembersEnd);

    }

    public function testExtract()
    {
        $zippy = $this->zipper;
        $archiveSource = $this->fileHelper->assetsDir.'/add/archive_all.'.$this->ext;
        $archiveDest = $this->fileHelper->archiveDir.'/archive_extracting.'.$this->ext;
        copy($archiveSource, $archiveDest);
        $archiveZip = $zippy->open($archiveDest, $this->type);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);
        $extractingFolder = $this->fileHelper->makeArenaFolder('extracting');
        $archiveZip->extract($extractingFolder);
        $items = scandir($extractingFolder);
        $items = array_filter($items, function($item){
            return ($item != '.' && $item != '..');
        });

        $ok1 = in_array('file1.txt', $items)
            && in_array('file2.txt', $items)
            && in_array('file3.txt', $items);
        $ok2 = in_array('folder1', $items)
            && in_array('folder2', $items)
            && in_array('folder_empty', $items);

        $this->assertTrue($ok1);
        $this->assertTrue($ok2);
    }
    public function testExtractMembers()
    {
        $zippy = $this->zipper;
        $archiveSource = $this->fileHelper->assetsDir.'/add/archive_all.'.$this->ext;
        $archiveDest = $this->fileHelper->archiveDir.'/archive_extracting.'.$this->ext;
        copy($archiveSource, $archiveDest);
        $archiveZip = $zippy->open($archiveDest, $this->type);
        $this->assertInstanceOf(\Alchemy\Zippy\Archive\ArchiveInterface::class, $archiveZip);
        $extractingFolder = $this->fileHelper->makeArenaFolder('extracting');
        $archiveZip->extract($extractingFolder);
        $items = scandir($extractingFolder);
        $items = array_filter($items, function($item){
            return ($item != '.' && $item != '..');
        });

        $ok1 = in_array('file1.txt', $items)
            && in_array('file2.txt', $items)
            && in_array('file3.txt', $items);
        $ok2 = in_array('folder1', $items)
            && in_array('folder2', $items)
            && in_array('folder_empty', $items);

        $this->assertTrue($ok1);
        $this->assertTrue($ok2);
    }

    public function testGetVersion()
    {
        $zippy = $this->zipper;
        $versionDeflator = $zippy->getDeflatorVersion();
        $versionInflator = $zippy->getInflatorVersion();

        if ($this->type === '7zip') {
            $this->assertTrue(is_numeric($versionDeflator));
            $this->assertTrue(is_numeric($versionInflator));
            $this->assertGreaterThan(0, $versionDeflator);
            $this->assertGreaterThan(0, $versionInflator);

            return;
        }

        $this->assertIsString($versionDeflator);
        $this->assertIsString($versionInflator);
        $this->assertNotSame('', trim($versionDeflator));
        $this->assertNotSame('', trim($versionInflator));
    }

    private function has7zipBinary(): bool
    {
        $finder = new ExecutableFinder();

        foreach (['7za', '7z'] as $bin) {
            if ($finder->find($bin) !== null) {
                return true;
            }
        }

        return false;
    }
}
