<?php
	class indexController {
		private $_global;
		
		public function __construct($global) {
			$this->_global = $global;
			require_once (PATH_VIEWS."heads/indexHead.php");
		}
		
		public function run() {
			$categories = $this->_global['db']->getCategories();
			$randomCategories = array_rand($categories, 3);
			$lastQuestions = $this->_global['db']->getQuestions('nbr', 3);
			
			require_once (PATH_VIEWS."index.php");
		}
	}