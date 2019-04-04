<?php
	class questionController {
		private $_db;
		
		public function __construct($_db) {
			$this->_db = $_db;
			require_once (PATH_VIEWS."heads/questionHead.php");
		}
	}