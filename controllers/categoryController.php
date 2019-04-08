<?php
	class categoryController {
		private $_global;
		private $_category;
		private $_questions;
		
		public function __construct($global) {
			$this->_global = $global;
			switch ($_GET['referer']) {
				case "all":
					$this->_category['name'] = "Toutes";
					break;
					
				default:
					$this->_category = $this->_global['db']->getCategory($_GET['referer']);
					if (empty($this->_category)) throw new Error('404');
					$this->_questions = $this->_global['db']->getQuestions("cat", $_GET['referer']);
			}
			require_once (PATH_VIEWS."heads/categoryHead.php");
		}
		
		public function run() {

		}
	}