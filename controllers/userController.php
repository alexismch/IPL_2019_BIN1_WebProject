<?php
	class userController {
		private $_global;
		private $_user;
		private $_questions;

		public function __construct($global) {
			$this->_global = $global;
			$this->_user=$this->_global['db']->getUser($_GET['username']);

			$this->_questions=$this->_global['db']->getQuestionsUser($this->_user->getId());

			if(empty($this->_user)) throw new Error("404");

            $cleanUserName = $this->_global['fn']->clean($this->_user->getUsername());

            if ($cleanUserName !== $_GET['username']) {
                header("Location: /question/".$cleanUserName);
                exit();
            }

			require_once (PATH_VIEWS."heads/userHead.php");
		}
		
		public function run() {

            $notification='';


            if(isset($_SESSION['isConnected']) && $_SESSION['isConnected']&&$_SESSION['isAdmin'] &&!empty($_POST['suspendre'])){
                if($this->_global['db']->isLocked($this->_user->getId())) {
                    $notification = "vous avez suspendu ce compte";
                }


            }
            else{
                $notification="vous n'avez pas le droit de suspendre";
            }

            require_once (PATH_VIEWS."user.php");
		}
	}