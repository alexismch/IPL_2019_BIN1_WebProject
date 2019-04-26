<?php
	class userController {
		private $_global;
		private $_user;
		private $_questions;
        private $_userNames;
		public function __construct($global) {
			$this->_global = $global;




			if(!empty($this->_global['db']->getUser($_GET['username']))){


                $this->_user = $this->_global['db']->getUser($_GET['username']);

                $this->_questions = $this->_global['db']->getQuestionsUser($this->_user->getId());

                if (empty($this->_user)) throw new Error("404");

                $cleanUserName = $this->_global['fn']->clean($this->_user->getUsername());
            }
            else{
                $this->_userNames=$this->_global['db']->getAllUsers();
                header("Location: /user/");
            }


			require_once (PATH_VIEWS."heads/userHead.php");
		}
		
		public function run() {

            $notification='';


            if(isset($_SESSION['isConnected']) && $_SESSION['isConnected']&&$_SESSION['isAdmin'] &&!empty($_POST['suspendre'])){
                if($this->_global['db']->isLocked($this->_user->getId())) {
                    $notification = "vous avez suspendu ce compte";
                    $_SESSION['code'] = "S7";
                    header("Location: /user/".$this->_user->getUsername());
                }
            }
            if(isset($_SESSION['isConnected']) && $_SESSION['isConnected']&&$_SESSION['isAdmin'] &&!empty($_POST['Admin'])){
                if($this->_global['db']->isAdmin($this->_user->getId())) {
                    $_SESSION['code'] = "S8";
                    header("Location: /user/".$this->_user->getUsername());

            }
            }


            require_once (PATH_VIEWS."user.php");
		}
	}