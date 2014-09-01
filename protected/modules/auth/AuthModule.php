<?php

class AuthModule extends CModule
{
    
    private $_passwd = array();
    private $_salt = '';
    
    public function auth($login=null, $password=null)
    {
        if ($login && $password) {
            $this->login($login, $password);
            return $this->auth();
        }
        return ($this->session) ? true : false;
    }
    
    private function login($login, $password)
    {
        if (!isset($this->_passwd[$login])) {
            return false;
        }
        if ($this->_passwd[$login] === md5($this->_salt . $password)) {
            session_register('ltime');
            session_register('data');
            $_SESSION['ltime'] = time();
            $_SESSION['data'] = array();
            return true;
        }
        return false;
    }
    
    public function getSession()
    {
        return (isset($_SESSION) && isset($_SESSION['data'])) ? $_SESSION['data'] : null;
    }
    
    public function setSession()
    {
        var_dump('SetSession');
    }
    
    public function logout()
    {
        session_unregister('data');
        session_unregister('ltime');
    }
    
    public function passwd($login, $password)
    {
        if (!isset($this->_passwd[$login])) {
            return false;
        }
        $this->_passwd[$login] = md5($this->_salt . $password);
    }
    
    public function init($config)
    {
        if(session_id() == '') {
            session_start();
        }
        $this->_passwd = FSMiniApp::app()->ds->get('auth_passwd');
        parent::init($config);
    }
    
    public function setSalt($salt)
    {
        $this->_salt = $salt;
    }
}
