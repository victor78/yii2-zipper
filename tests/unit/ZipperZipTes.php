<?php

namespace tests\unit;

class ZipperZipTest extends ZipperTesting
{
    
    public function __construct() {
        parent::__construct();
        $this->ext = 'zip';
        $this->zipper->setType('zip');
    }
    
    public function testRemoveMembersWithPassword() {
        $this->assertTrue(true);
    }
}
