<?php

class CComponent
{
    
    public function __get($key)
    {
        $mname = 'get' . ucfirst($key);
        if (property_exists(get_class($this), $key)) {
            return $this->$key;
        } elseif (method_exists($this, $mname)) {
            return $this->$mname();
        } else {
            throw new Exception('Property "' . $key  . '" does not exists in ' . get_class($this));
        }
    }
    
    public function __set($key, $val)
    {
        $mname = 'set' . ucfirst($key);
        if (property_exists(get_class($this), $key)) {
            $this->$key = $val;
        } elseif (method_exists($this, $mname)) {
            $this->$mname($val);
        } else {
            throw new Exception('Property "' . $key  . '" does not exists in ' . get_class($this));
        }
    }
    
}