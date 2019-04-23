<?php
	class searchController {
		private $_global;
        private $_keyWord;
		private $_questions;
		private $notification;

		public function __construct($global) {
			$this->_global = $global;

            $this->_keyWord=$_GET['value'];

            $this->_questions = $this->_global['db']->getQuestionsSearch($this->_keyWord);

			require_once (PATH_VIEWS."heads/searchHead.php");
		}
		
		public function run() {
            if(empty($this->_keyWord)){
                $notification='vous n\'avez pas faits de recherche';

            }
            else{
                $notification=$this->_keyWord;
            }
            if(empty($this->_questions)){
                $notification="pas de résultats pour votre recherche";
            }

            require_once (PATH_VIEWS."search.php");
		}
	}
	?>