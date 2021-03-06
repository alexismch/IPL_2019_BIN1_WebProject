<?php
	class userController {
		private $_global;
		private $_user;
		private $_questions;
        private $_allUsers;

		public function __construct($global) {
			$this->_global = $global;

			if ($_GET['username'] === "all") {
				if (!isset($_SESSION['isConnected']) || !$_SESSION['isConnected'] || !$_SESSION['isAdmin']) {#if the user is not an Admin or not connected he doesn't have access
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
                $currentUser=unserialize($_SESSION['user']);#unserialize($_SESSION['user']) return an object of user type

                if(!empty($_POST['setAdmin'])&&$this->_global['db']->setAdmin($_POST['setAdmin'],1)) {#only admins have access to users
                    $_SESSION['code'] = "S8";
                    header("Location: /user/all");
                }
                if(!empty($_POST['setMember'])&&$currentUser->getId()!=$_POST['setMember']&&$this->_global['db']->setAdmin($_POST['setMember'],0)) {
                    $_SESSION['code'] = "S10";
                    header("Location: /user/all");
                }
                elseif (!empty($_POST['setMember'])&&$currentUser->getId()===$_POST['setMember']) $_SESSION['code']="E8";
                if(!empty($_POST['setLocked'])&&$currentUser->getId()!=$_POST['setLocked']&&$this->_global['db']->setLocked($_POST['setLocked'],1)) {
                    $_SESSION['code'] = "S7";
                    header("Location: /user/all");
                }
                elseif (!empty($_POST['setLocked'])&&$currentUser->getId()===$_POST['setLocked']) $_SESSION['code']="E8";
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
		#
        #takes as parameter a question
        #return the category of that question.
		public function getCategoryById ($question){
		    return $this->_global['db']->getCategoryById($question['category_id']);
        }

	}