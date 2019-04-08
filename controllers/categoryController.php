<?php
	class categoryController {
		private $_global;
		private $_category;
		
		public function __construct($global) {
			$this->_global = $global;
			$this->_category = $this->_global['db']->getQuestions("cat", $_GET['referer']);
			if (empty($this->_category)) throw new Error('404');
			require_once (PATH_VIEWS."heads/categoryHead.php");
		}
		
		public function run() {

		}
	}