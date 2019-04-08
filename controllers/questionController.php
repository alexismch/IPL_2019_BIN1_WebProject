<?php
	class questionController {
		private $_global;
		private $_question;
		private $_answers;
		
		public function __construct($global) {
			$this->_global = $global;
			$this->_question = $this->_global['db']->getQuestion($_GET['id']);
			$cleanTitle = $this->_global['fn']->clean($this->_question['title']);
			if (empty($this->_question)) throw new Error("404");
			if ($cleanTitle !== $_GET['title']) {
				header("Location: /question/".$_GET['id']."/".$cleanTitle);
				exit();
			}
			$this->_answers = $this->_global['db']->getAnswers($_GET['id']);
			require_once (PATH_VIEWS."heads/questionHead.php");
		}
		
		public function run() {
			require_once (PATH_VIEWS."question.php");
		}
	}