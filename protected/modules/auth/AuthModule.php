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
        return ($this->session === null) ? false : true;
    }
    
    public function requireAuth($return_url = '/login')
    {
        if (!$this->auth()) {
            FSMiniApp::app()->redirect($return_url);
        }
    }
    
    public function addUser($login, $password)
    {
        if (isset($this->_passwd[$login])) {
            throw new Exception('The login "' . $login . '" already exists');
        }
        $this->_passwd[$login] = md5($this->_salt . $password);
        $this->savePasswd();
    }
    
    private function login($login, $password)
    {
        if (!isset($this->_passwd[$login])) {
            return false;
        }
        if ($this->_passwd[$login] === md5($this->_salt . $password)) {
            if (function_exists('session_register')) {
                session_register('ltime');
                session_register('data');
            }
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
        if (function_exists('session_unregister')) {
            session_unregister('data');
            session_unregister('ltime');
        } else {
            unset($_SESSION['data']);
            unset($_SESSION['ltime']);
        }
        session_destroy();
    }
    
    public function passwd($login, $password)
    {
        if (!isset($this->_passwd[$login])) {
            return false;
        }
        $this->_passwd[$login] = md5($this->_salt . $password);
        $this->savePasswd();
    }
    
    private function savePasswd()
    {
        FSMiniApp::app()->ds->set('auth_passwd', $this->_passwd);
    }
    
    public function init($config)
    {
        if(session_id() == '') {
            session_start();
        }
        $this->_passwd = FSMiniApp::app()->ds->get('auth_passwd');
        parent::init($config);
        if (!$this->_passwd) {
            $this->addUser('admin', 'admin');
            $this->savePasswd();
        }
    }
    
    public function setSalt($salt)
    {
        $this->_salt = $salt;
    }
    
    public function getList()
    {
        $list = array();
        foreach ($this->_passwd as $login => $p) $list[] = $login;
        return $list;
    }
    
    public function delete($login)
    {
        if (!key_exists($login, $this->_passwd)) {
            throw new Exception('Login "' . $login . '" does not exsits');
        }
        unset($this->_passwd[$login]);
        $this->savePasswd();
    }
}
