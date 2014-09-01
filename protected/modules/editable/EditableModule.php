<?php

class EditableModule extends CModule
{
    
    
    public function edit($selector)
    {
        $script = "$(document).ready(function(){ 
            Aloha.ready(function() {
            var el = Aloha.jQuery('{$selector}');
            el.aloha();
            
            var changePending = false;

            function elChanged()
            {
                if (changePending) {
                    clearTimeout(changePending);
                }
                changePending = setTimeout(function(){
                    console.log('SAVE!');
                }, 1300);
            }

            el.bind('keydown', function(event) {
                elChanged();
            });
            el.bind('click', function(event) {
                elChanged();
            });
            el.bind('blur', function(event) {
                elChanged();
            });
        });"
            . "});";
        FSMiniApp::app()->script->registerScript('editable-' . $selector, $script);
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
								common/align,
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
                                        extra/videoblock'));
        FSMiniApp::app()->registerCssFile($dir . '/css/aloha.css');
        parent::init($config);
    }
}