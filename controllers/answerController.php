<?php
	class answerController {
		private $_global;
		
		public function __construct($global) {
			$this->_global = $global;
			switch ($_GET['action']) {
				case "add":
					if (!isset($_SESSION['isConnected']) || !$_SESSION['isConnected']) {
						$_SESSION['code'] = "E1";
						header("Location: /login");
						exit();
					}
					break;
					
				case "vote":
					if (!isset($_SESSION['isConnected']) || !$_SESSION['isConnected']) {
						$_SESSION['code'] = "E2";
						header("Location: /login");
						exit();
					}
					break;
					
				case "mark":
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
			}
		}
	}
