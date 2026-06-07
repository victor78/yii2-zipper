<?php

namespace tests\unit;

require_once 'ZipperTesting.php';

class ZipperZipTest extends ZipperTesting
{
    public $type = 'zip';
    public $ext = 'zip';

    public function testRemoveMembersWithPassword()
    {
        $this->markTestSkipped('Standard zip adapter does not support password protection.');
    }
}
