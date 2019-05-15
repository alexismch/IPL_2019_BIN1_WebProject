<?php
	class questionController {
		private $_global;
		private $_question;
		private $_answers;
		private $_answersVoted;
		
		public function __construct($global) {
			$this->_global = $global;

			if (isset($_POST['duplicate'])) {#check if $_POST['duplicate'] is declared and not null? if it'true then execute the code: if not then exceute else
				$refererId = $_POST['refererId'];
				if ($this->_global['db']->setDuplicated($_GET['id'], $refererId)) {
					$_SESSION['code'] = "S11";
					header("Location: ".$_SERVER['REDIRECT_URL']);
					exit();
				}
			} else if (isset($_POST['delete'])){ #same then before
                if($this->_global['db']->deleteQuestion($_GET['id'])){
                    $_SESSION['code'] = "S12";
                    header("Location: /");
                    exit();
                }
            } else if (isset($_POST['open'])){
			    if($this->_global['db']->setOpen($_GET['id'])){
			        $_SESSION['code']="S11";
                    header("Location: ".$_SERVER['REDIRECT_URL']);#redirects to the page of the question
                    exit();
                }
            } else if (isset($_GET['action']) && $_GET['action'] === "add") {
				if (!isset($_SESSION['isConnected']) || !$_SESSION['isConnected']) {
					$_SESSION['form']['formURL'] = "/question/add";
					$_SESSION['code'] = "E9";
					header("Location: /login");
					exit();
				} else if (isset($_POST['add-question-form'])) {
					$title = $_POST['title'];
					$cat = $_POST['category'];
					$subject = $_POST['subject'];
					$id = $this->_global['db']->addQuestion($title, $cat, $subject);
					$_SESSION['code'] = "S14";
					header("Location: /question/".$id);
					exit();
				} else
					$this->_question['title'] = "Ajouter une question";
			} else {
				if (isset($_POST['edit-form'])) {
					$this->_global['db']->editQuestion($_GET['id'], $_POST['title'], $_POST['category'], $_POST['subject'], $_POST['state']);
					$_SESSION['code'] = "S15";
				}
				$this->_question = $this->_global['db']->getQuestion($_GET['id']);
				$cleanTitle = $this->_global['fn']->clean($this->_question['title']);
				if (empty($this->_question)) throw new Error("404");
				if ($cleanTitle !== $_GET['title']) {
					header("Location: /question/".$_GET['id']."/".$cleanTitle);
					exit();
				}
				$this->_answers = $this->_global['db']->getAnswers($_GET['id']);
				if (isset($_SESSION['isConnected']) && $_SESSION['isConnected']) $this->_answersVoted = $this->_global['db']->getAnswersVoted($this->_question['question_id']);
			}
			
			require_once (PATH_VIEWS."heads/questionHead.php");
		}
		
		public function run() {
			if (isset($_GET['action']) && $_GET['action'] === "add") {
				$categories = $this->_global['db']->getCategories();
				require_once (PATH_VIEWS."questionForm.php");
			} else {
				$categories = [];
				$isOwner = false;
				$correctAnswer = $this->_question['correct_answer_id'];
				if (isset($_SESSION['user'])) {
					$user = unserialize($_SESSION['user']);
					if ($this->_question['username'] === $user->getUsername()) $isOwner = true;
					if ($isOwner) {
						$categories = $this->_global['db']->getCategories();
					}
				}
				
				require_once (PATH_VIEWS."question.php");
			}
		}
	}