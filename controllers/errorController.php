<?php
	class errorController {
		private $_global;
		private $_code;
		private $_message;
		
		public function __construct($global, $msg, $code) {
			$this->_global = $global;
			$this->_code = $code;
			$this->_message = $msg;
			require_once (PATH_VIEWS."heads/errorhead.php");
		}
		
		public function run() {
			require_once (PATH_VIEWS."error.php");
		}
	}