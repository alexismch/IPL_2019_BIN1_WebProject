<?php
	class categoryController {
		private $_global;
		private $_category;
		
		public function __construct($global) {
			$this->_global = $global;
			switch ($_GET['referer']) {
				case "all":
					$this->_category['name'] = "Toutes";
					break;
					
				default:
					$this->_category = $this->_global['db']->getCategory($_GET['referer']);
					if (empty($this->_category)) throw new Error('404');
			}
			require_once (PATH_VIEWS."heads/categoryHead.php");
		}
		
		public function run() {
			switch ($this->_category['name']) {
				case "Toutes":
					$categories = $this->_global['db']->getCategories();
					require_once (PATH_VIEWS."categories.php");
					break;
					
				default:
					$questions = $this->_global['db']->getQuestions("cat", $this->_category['link_referer']);
					require_once (PATH_VIEWS."category.php");
					break;
			}
		}
	}