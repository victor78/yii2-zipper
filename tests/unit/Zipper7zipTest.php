<?php

namespace tests\unit;

class Zipper7zipTest extends ZipperTesting
{
    
    public function __construct() {
        parent::__construct();
        $this->zipper->setType('7zip');
    }
}
