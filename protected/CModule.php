<?php

class CModule extends CComponent
{
    
    
    public function init($config)
    {
        if (is_array($config)) {
            foreach ($config as $k => $v) {
                $this->$k = $v;
            }
        }
    }
}