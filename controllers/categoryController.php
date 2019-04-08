<?php
	class categoryController {
		private $_global;
		
		public function __construct($global) {
			$this->_global = $global;
			require_once (PATH_VIEWS."heads/categoryHead.php");
		}
		
		public function run() {
		
		}
	}