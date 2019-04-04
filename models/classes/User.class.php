<?php
/**
 * Created by PhpStorm.
 * User.class: gdecrom18
 * Date: 04-04-19
 * Time: 14:48
 */

	class User {
	    private $_no;
	    private $_username;
	    private $_pwd;
	
	    public function __construct($no,$username,$pwd) {
	        $this->_no = $no;
	        $this->_username = $username;
	        $this->_pwd = $pwd;
	    }
	
	    public function no() {
	        return $this->_no;
	    }
	
	    public function username() {
	        return $this->_username;
	    }
	
	    public function pwd() {
	        return $this->_pwd;
	    }
	    public function html_no() {
	        return htmlspecialchars($this->_no);
	    }
	
	    public function html_username() {
	        return htmlspecialchars($this->_username);
	    }
	
	    public function html_pwd() {
	        return htmlspecialchars($this->_pwd);
	    }
	}