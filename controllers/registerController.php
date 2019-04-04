<?php
	class registerController {
		private $_global;
		
		public function __construct($global) {
			$this->_global = $global;
			require_once (PATH_VIEWS."heads/registerHead.php");
		}
	}