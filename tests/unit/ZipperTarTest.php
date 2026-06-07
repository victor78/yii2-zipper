<?php

namespace tests\unit;

require_once 'ZipperTesting.php';

class ZipperTarTest extends ZipperTesting
{
    public $type = 'tar';
    public $ext = 'tar';

    public function testRemoveMembersWithPassword()
    {
        $this->markTestSkipped('Tar adapter does not support password protection.');
    }
}
