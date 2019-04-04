<?php
	class indexController {
		private $_db;
		
		public function __construct($db) {
			$this->_db = $db;
			require_once (PATH_VIEWS."heads/indexHead.php");
		}
		
		public function run() {
			$categories = $this->_db->getCategories();
			$randomCategories = array_rand($categories, 3);
			$lastQuestions = $this->_db->getQuestions('last');
			
			require_once (PATH_VIEWS."index.php");
		}
	}