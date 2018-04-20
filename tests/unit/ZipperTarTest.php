<?php

namespace tests\unit;

class ZipperTarTest extends ZipperTesting
{
    public function __construct() {
        parent::__construct();
        $this->ext = 'tar';
        $this->zipper->setType('tar');
        echo "Tar inflator version: " . $this->zipper->getInflatorVersion() . PHP_EOL;
        echo "Tar deflator version: " . $this->zipper->getDeflatorVersion() . PHP_EOL;
    }
    
    public function testRemoveMembersWithPassword() {
        $this->assertTrue(true);
    }    
}
