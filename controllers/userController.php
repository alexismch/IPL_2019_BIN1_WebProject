<?php
	class userController {
		private $_global;
		
		public function __construct($global) {
			$this->_global = $global;
			require_once (PATH_VIEWS."heads/userHead.php");
		}
		
		public function run() {
		
		}
	}