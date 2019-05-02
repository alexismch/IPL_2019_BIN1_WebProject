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





			if(!empty($_POST['Delete'])&&$this->_global['db']->setCorrectAnswer($_GET['id'])&&$this->_global['db']->deleteVotes($_GET['id'])) {
                if ($this->_global['db']->deleteAnswers($_GET['id'])) {

                    if ($this->_global['db']->deleteQuestion($_GET['id'])) {

                        $_SESSION['code'] = "S12";
                        header("Location:/");

                    }
                }
            }
            if(!empty($_POST['url'])){

                $referer_question_id=$_POST['url'];
                $referer_question_id=mb_ereg_replace("[^0-9]",'',$referer_question_id) ;
                if(!is_bool($referer_question_id)&&$this->_global['db']->setDuplicated($_GET['id'],$referer_question_id)){
                    $this->_global['db']->changeStateQuestion($_GET['id'],'d');
                    $_SESSION['code'] = "S11";
                    header("Location: /question/".$_GET['id']."/");
                }

            }

			require_once (PATH_VIEWS."question.php");
		}
	}