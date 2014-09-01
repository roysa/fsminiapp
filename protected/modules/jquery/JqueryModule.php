<?php

class JqueryModule extends CModule
{
    
    
    public function init($config)
    {
        $dir = FSMiniApp::app()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor');
        FSMiniApp::app()->registerScriptFile($dir . '/jquery-1.11.1.min.js');
        FSMiniApp::app()->registerScriptFile($dir . '/jquery-migrate-1.2.1.js');
        parent::init($config);
    }
}
