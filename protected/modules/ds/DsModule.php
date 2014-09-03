<?php

class DsModule extends CModule
{
    
    
    public function get($key)
    {
        $filename = $this->storagePath . md5($key);
        if (!file_exists($filename)) {
            return null;
        }
        return unserialize(file_get_contents($filename));
    }
    
    public function set($key, $value)
    {
        $filename = $this->storagePath . md5($key);
        file_put_contents($filename, serialize($value));
    }
    
    public function getStoragePath()
    {
        $p = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
        if (!file_exists($p)) {
            mkdir($p, 0700, true);
        }
        return $p;
    }
    
}
