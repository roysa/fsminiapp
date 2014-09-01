<?php

class ScriptModule extends CModule
{
    
    private $f_js = array();
    private $f_js_options = array();
    private $f_css = array();
    private $f_css_options = array();
    private $scripts = array();
    
    public function registerScriptFile($f, $pos = null, $htmlOptions=array())
    {
        if (in_array($f, $this->f_js)) {
            return;
        }
        $this->f_js[] = $f;
        $this->f_js_options[] = $htmlOptions;
    }
    
    public function registerCssFile($f, $htmlOptions=array())
    {
        if (in_array($f, $this->f_css)) {
            return;
        }
        $this->f_css[] = $f;
        $this->f_js_options[] = $htmlOptions;
    }
    
    public function registerScript($id, $s, $htmlOptions=array())
    {
        if (isset($this->scripts[$id])) {
            return;
        }
        $this->scripts[$id] = $s;
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
