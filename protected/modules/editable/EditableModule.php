<?php

class EditableModule extends CModule
{
    
    
    public function edit($selector)
    {
        $script = "$(document).ready(function(){ 
            Aloha.ready(function() {
            console.log('Setting Aloha for ' + '{$selector}');
            Aloha.jQuery('{$selector}').aloha();
        });"
            . "});";
        FSMiniApp::app()->script->registerScript($script);
    }
    
    public function init($config)
    {
//        FSMiniApp::app()->jquery;
        $dir = FSMiniApp::app()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'aloha/');
//        FSMiniApp::app()->registerScriptFile($dir . '/lib/aloha-config.js');
        FSMiniApp::app()->registerScriptFile($dir . '/lib/require.js');
        FSMiniApp::app()->registerScriptFile($dir . '/lib/vendor/jquery-1.7.2.js');
        
        FSMiniApp::app()->registerScriptFile($dir . '/lib/aloha.js', null, array('data-aloha-plugins' => 'common/ui,
								common/format,
		                        common/table,
		                        common/list,
		                        common/link,
		                        common/highlighteditables,
		                        common/block,
		                        common/undo,
		                        common/image,
		                        common/contenthandler,
		                        common/paste,
		                        common/commands,
		                        common/abbr'));
        FSMiniApp::app()->registerCssFile($dir . '/css/aloha.css');
        parent::init($config);
    }
}