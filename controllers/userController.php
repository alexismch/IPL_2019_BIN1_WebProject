<?php
	class userController {
		private $_global;
		private $_user;
		private $_questions;
        private $_allUsers;
#
#
#on ne peux pas mettre Son compte en tant que membre
#
#
		public function __construct($global) {
			$this->_global = $global;

			if ($_GET['username'] === "all") {
				if (!isset($_SESSION['isConnected']) || !$_SESSION['isConnected'] || !$_SESSION['isAdmin']) {
					throw new Error("Vous n'avez pas accès à cette page...","403");
				}
				$this->_allUsers = $this->_global['db']->getAllUsers();
			} else {
				$this->_user = $this->_global['db']->getUser($_GET['username']);
				if (empty($this->_user)) {
					throw new Error("Utilisateur inexistant...", "404");
				}
				$this->_questions=$this->_global['db']->getQuestionsUser($this->_user->getId());
			}

			require_once (PATH_VIEWS."heads/userHead.php");
		}
		
		public function run() {
            if($_GET['username'] === "all"){

                if(!empty($_POST['setAdmin'])&&$this->_global['db']->setAdmin($_POST['setAdmin'],1)) {
                    $_SESSION['code'] = "S8";
                    header("Location: /user/all");
                }
                if(!empty($_POST['setMember'])&&$this->_global['db']->setAdmin($_POST['setMember'],0)) {
                    $_SESSION['code'] = "S10";
                    header("Location: /user/all");
                }
                if(!empty($_POST['setLocked'])&&$this->_global['db']->setLocked($_POST['setLocked'],1)) {
                    $_SESSION['code'] = "S7";
                    header("Location: /user/all");
                }
                if(!empty($_POST['setOnLine'])&&$this->_global['db']->setLocked($_POST['setOnLine'],0)) {

                    $_SESSION['code'] = "S9";
                    header("Location: /user/all");
                }

                require_once (PATH_VIEWS."users.php");
            }
            else {

	            require_once (PATH_VIEWS."user.php");
            }
		}

	}