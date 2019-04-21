<?php
	class User {
	    private $_id;
	    private $_name;
	    private $_firstname;
	    private $_username;
	    private $_email;
	    private $_passwd;
	    private $_isLocked;
	    private $_isAdmin;
        public static $_nbMembre=3;
		public function __construct($_id, $_name, $_firstname, $_username, $_email, $_passwd, $_isLocked, $_isAdmin) {
			$this->_id = $_id;
			$this->_name = $_name;
			$this->_firstname = $_firstname;
			$this->_username = $_username;
			$this->_email = $_email;
			$this->_passwd = $_passwd;
			$this->_isLocked = $_isLocked;
			$this->_isAdmin = $_isAdmin;
		}
		
		public function getId() {
			return $this->_id;
		}
		
		public function getName() {
			return $this->_name;
		}
		
		public function getFirstname() {
			return $this->_firstname;
		}
		
		public function getUsername() {
			return $this->_username;
		}
		
		public function getEmail() {
			return $this->_email;
		}

		public function isLocked() {
			return $this->_isLocked;
		}
		
		public function isAdmin() {
			return $this->_isAdmin;
		}
		
		public function isValidPasswd($passwd) {
			return password_verify($passwd, $this->_passwd);
		}

	}