<?php

namespace Victor78\Zipper;

use yii\base\Component;

use Victor78\ZippyExt\Zippy;

class Zipper extends Component
{
    protected $zippy;
    public $type = 'zip';
    public $password;
    
    
    public function init() 
    {
        $this->zippy = Zippy::load();        
    }
    
    public function setType($type)
    {
        $this->type = $type;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    public function create($path, $files = null, $recursive = true, $type = null, $password = null)
    {
        return $this->zippy->create($path, $files, $recursive, 
            $type ? $type : $this->type, 
            $password ? $password : $this->password);
    }
    
    public function open($path, $type = null, $password = null)
    {
        return $this->zippy->open($path, 
            $type ? $type : $this->type, 
            $password ? $password : $this->password);
    }
    
    public function getInflatorVersion($type = null)
    {
        if (!$type){
            $type = $this->type;
        }
        $adapter = $this->zippy->getAdapterFor($type);
        $version = $adapter->getInflatorVersion();
        return $version;
    }
    
    public function getDeflatorVersion($type = null)
    {
        if (!$type){
            $type = $this->type;
        }
        $adapter = $this->zippy->getAdapterFor($type);
        $version = $adapter->getDeflatorVersion();
        return $version;
    }
}