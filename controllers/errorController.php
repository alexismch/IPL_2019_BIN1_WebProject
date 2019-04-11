<?php
	class errorController {
		private $_global;
		private $_code;
		private $_message;
		
		public function __construct($global, $code) {
			$code_array = parse_ini_file(PATH_MODELS."code.ini", true);
			$this->_global = $global;
			$this->_code = $code;
			$this->_message = $code_array[$code];
			require_once (PATH_VIEWS."heads/errorhead.php");
		}
		
		public function run() {
			require_once (PATH_VIEWS."error.php");
		}
	}