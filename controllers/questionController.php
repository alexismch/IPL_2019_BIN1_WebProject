<?php
	class questionController {
		private $_global;
		private $_question;
		private $_answers;
		private $_answersVoted;
		
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
			if (isset($_SESSION['isConnected']) && $_SESSION['isConnected']) $this->_answersVoted = $this->_global['db']->getAnswersVoted($this->_question['question_id']);
			require_once (PATH_VIEWS."heads/questionHead.php");
		}
		
		public function run() {
			$isOwner = false;
			$correctAnswer = $this->_question['correct_answer_id'];
			if (isset($_SESSION['user'])) {
				$user = unserialize($_SESSION['user']);
				if ($this->_question['username'] === $user->getUsername()) $isOwner = true;
			}
			require_once (PATH_VIEWS."question.php");
		}
	}