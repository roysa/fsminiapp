<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'CComponent.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'CModule.php';

class FSMiniApp extends CComponent
{
    
    protected $_layout = 'main';
    protected $_modules = array();
    protected static $_tstart = null;
    
    protected static $_instance = null;
    
    protected static function log($msg)
    {
        if (!self::$_tstart) {
            self::$_tstart = microtime(true);
        }
        $t = round(microtime(true) - self::$_tstart, 3);
        echo "{$t}\t{$msg}\n";
    }


    private function __construct() { }
    
    public static function app($config=null)
    {
        static $instance = null;
        if (null === $instance && $config) {
            self::$_tstart = microtime(true);
            $instance = new static();
            $instance->__init($config);
        }
        return $instance;
    }
    
    public function __init($config)
    {
        /**
         * Load modules
         */
        if (isset($config['modules'])) {
            foreach ($config['modules'] as $mname => $mconf) {
                if ($mconf == false) {
                    continue;
                }
                $class_name = ucfirst($mname) . 'Module';
                $filename = $this->modulesPath . $mname . DIRECTORY_SEPARATOR . $class_name . '.php';
                if (!file_exists($filename)) {
                    throw new Exception('Module file for "' . $mname . '" does not exists');
                }
                require $filename;
                if (!class_exists($class_name, false)) {
                    throw new Exception('Class "' . $class_name . '" was not found');
                }
                $this->_modules[$mname] = array(
                    'module' => new $class_name(),
                    'config' => $mconf,
                    'initialized' => false,
                );
            }
        }
    }
    
    
    
    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $route = explode('/', preg_replace('/\?.+$/', '', $uri));
        $page = ($route[1]) ? $route[1] : 'index';
        $params = array();
        if (preg_match('/^\/\w+\/([^\?]+)/', $uri, $m)) {
            $m = explode('/', $m[1]);
            foreach ($m as $mm) {
                $params[] = $mm;
            }
        }
        if (preg_match('/\?(.+)$/', $uri, $m)) {
            $m = explode('&', $m[1]);
            foreach ($m as $s) {
                $s = explode('=', $s);
                $params[$s[0]] = (isset($s[1])) ? $s[1] : '';
            }
        }
        $this->runPage($page, $params);
    }
    
    public function runPage($page, $params)
    {
        $filename = $this->appPath . 'pages' . DIRECTORY_SEPARATOR . $page . '.php';
        if (!file_exists($filename)) {
            http_response_code(404);
            if ($page === '404') {
                throw new Exception('Page 404 was not found');
            } else {
                return $this->runPage('404', $params);
            }
        }
        ob_start();
        include $filename;
        $content = ob_get_contents();
        ob_end_clean();
        include $this->layout;
    }
    
    public function redirect($url=null, $code=302)
    {
        if ($url === null) {
            $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        }
        http_response_code($code);
        header('Location: ' . $url);
        die();
    }
    
    public function getLayout($layout=null)
    {
        if ($layout === null) {
            $layout = $this->_layout;
        }
        $filename = $this->appPath . 'layouts' . DIRECTORY_SEPARATOR . $layout . '.php';
        if (!file_exists($filename)) {
            throw new Exception('Layout "' . $layout  . '" was not found');
        }
        return $filename;
    }
    
    public function setLayout($layout)
    {
        $this->getLayout($layout);
        $this->_layout = $layout;
    }
    
    public function getAppPath()
    {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }
    
    public function getModulesPath()
    {
        return $this->appPath . 'modules' . DIRECTORY_SEPARATOR;
    }
    
    public function __get($key)
    {
        if (isset($this->_modules[$key])) {
            if (!$this->_modules[$key]['initialized']) {
                $this->_modules[$key]['module']->init($this->_modules[$key]['config']);
                $this->_modules[$key]['initialized'] = true;
            }
            return $this->_modules[$key]['module'];
        }
        return parent::__get($key);
    }
    
    public function getBasePath($absolute=true)
    {
        return '/';
    }
    
}