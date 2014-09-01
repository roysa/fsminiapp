<?php

class ScriptModule extends CModule
{
    
    private $f_js = array();
    private $f_js_options = array();
    private $f_css = array();
    private $scripts = array();
    
    public function registerScriptFile($f, $pos = null, $htmlOptions=array())
    {
        $this->f_js[] = $f;
        $this->f_js_options[] = $htmlOptions;
    }
    
    public function registerCssFile($f)
    {
        $this->f_css[] = $f;
    }
    
    public function registerScript($s)
    {
        $this->scripts[] = $s;
    }
    
    public function make(&$html)
    {
        $script = '';
        foreach ($this->f_css as $css) {
            $script .= '<link rel="stylesheet" type="text/css" href="' . $css . '">' . "\n";
        }
        foreach ($this->f_js as $i => $js) {
            $script .= '<script src="' . $js . '" type="text/javascript" ' . $this->renderHtmlOptions($this->f_js_options[$i]) . '></script>' . "\n";
        }
        foreach ($this->scripts as $s) {
            $script .= '<script type="text/javascript">' . $s . '</script>';
        }
        $html = str_replace('</title>', "</title>\n" . $script, $html);
    }
    
    public function renderHtmlOptions($options)
    {
        $ret = ' ';
        foreach ($options as $name => $val) {
            $ret .= $name . '="' . $val . '" ';
        }
        return $ret;
    }
    
}
