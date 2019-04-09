<?php
	class voteController {
		private $_global;
		
		public function __construct($global) {
			$this->_global = $global;
			if (!isset($_SESSION['isConnected']) || !$_SESSION['isConnected']) {
				$_SESSION['code'] = "E1";
				header("Location: /login");
				exit();
			}
		}
		
		public function run() {
		
		}
	}