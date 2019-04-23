<?php
	class answerController {
		private $_global;
		
		public function __construct($global) {
			$this->_global = $global;
			switch ($_GET['action']) {
				case "add":
					if (!isset($_SESSION['isConnected']) || !$_SESSION['isConnected']) {
						$_SESSION['code'] = "E1";
						$_SESSION['form'] = $_POST;
						$_SESSION['form']['referer'] = $_SESSION['referer'];
						$_SESSION['form']['formURL'] = $_SERVER['REQUEST_URI'];
						header("Location: /login");
						exit();
					}
					break;
					
				case "vote":
					if (!isset($_SESSION['isConnected']) || !$_SESSION['isConnected']) {
						$_SESSION['code'] = "E2";
						$_SESSION['form'] = $_POST;
						$_SESSION['form']['referer'] = $_SESSION['referer'];
						$_SESSION['form']['formURL'] = $_SERVER['REQUEST_URI'];
						$_SESSION['form']['type'] = $_GET['type'];
						header("Location: /login");
						exit();
					}
					break;
					
				case "mark":
					if ($_GET['type'] !== "correct") {
						$referer = (empty($_SESSION['referer'])) ? "/" : $_SESSION['referer'];
						$_SESSION['code'] = "E7";
						header("Location: ".$referer);
						exit();
					}
					if (!isset($_SESSION['isConnected']) || !$_SESSION['isConnected']) {
						$_SESSION['code'] = "E3";
						header("Location: /login");
						exit();
					}
					$user = unserialize($_SESSION['user']);
					$owner = $this->_global['db']->getOwnerByAnswer($_GET['id']);
					if ($owner !== $user->getUsername()) {
						$_SESSION['code'] = "E4";
						header("Location: /");
						exit();
					}
					break;
			}
		}
		
		public function run() {
			switch ($_GET['action']) {
				case "mark":
					$this->_global['db']->markCorrectAnswer($_GET['id']);
					$_SESSION['code'] = "S3";
					header("Location: ".$_SESSION['referer']);
					exit();
					break;
					
				case "add":
					if (isset($_SESSION['form'])) {
						$answer = $_SESSION['form']['answer'];
						$questionId = $_SESSION['form']['questionId'];
						$referer = $_SESSION['form']['referer'];
						unset($_SESSION['form']);
					}
					else {
						$answer = $_POST['answer'];
						$questionId = $_POST['questionId'];
						$referer = $_SESSION['referer'];
					}
					if ($this->_global['db']->addAnswer($questionId, $answer)) $_SESSION['code'] = "S4";
					else $_SESSION['code'] = "E5";
					header("Location: ".$referer);
					exit();
					break;
					
				case "vote":
					if (isset($_SESSION['form'])) echo "ok";
					$error = false;
					$user = unserialize($_SESSION['user']);
					if (isset($_SESSION['form'])) {
						if ($_SESSION['form']['type'] === "up") $vote = 1;
						else if ($_SESSION['form']['type'] === "down") $vote = -1;
						else $error = true;
						$referer = $_SESSION['form']['referer'];
						unset($_SESSION['form']);
					} else {
						if ($_GET['type'] === "up") $vote = 1;
						else if ($_GET['type'] === "down") $vote = -1;
						else $error = true;
						$referer = $_SESSION['referer'];
					}
					if (empty($referer)) {
						$referer = "/";
						$error = true;
					}
					if ($error) {
						$_SESSION['code'] = "E6";
						header("Location: ".$referer);
						exit();
					}
					$this->_global['db']->voteForAnswer($_GET['id'], $vote);
					$_SESSION['code'] = "S5";
					header("Location: ".$referer);
					exit();
					break;
			}
		}
	}