<?php
	class searchController {
		private $_global;
        private $_keyWord;
		private $_questions;
		private $notificacation;
		public function __construct($global) {
			$this->_global = $global;

            $this->_keyWord=$_GET['key'];

            #$this->_questions = $this->_global['db']->getQuestionsSearch($_GET['key']);
            $this->_questions = $this->_global['db']->getQuestions();
			require_once (PATH_VIEWS."heads/searchHead.php");
		}
		
		public function run() {

            if(empty($this->_keyWord)){
                $notification='vous n\'avez pas faits de recherche';
            }
            else{
                $notification=$_GET['key'];
            }

            require_once (PATH_VIEWS.'search.php');
		}
	}
	?>