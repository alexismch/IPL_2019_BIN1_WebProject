<?php
	class userController {
		private $_global;
		private $_user;
		private $_questions;
        private $_allUsers;
        
		public function __construct($global) {
			$this->_global = $global;
			
			$this->_user = $this->_global['db']->getUser($_GET['username']);
			if (empty($this->_user)) {
				throw new Error("404");
			}
			$this->_questions=$this->_global['db']->getQuestionsUser($this->_user->getId());


			require_once (PATH_VIEWS."heads/userHead.php");
		}
		
		public function run() {
            if(!empty($_POST['allUsers'])){
                $this->_allUsers=$this->_global['db']->getAllUsers();
               require_once (PATH_VIEWS."users.php");
               exit();

            }
            
            if(isset($_SESSION['isConnected']) && $_SESSION['isConnected']&&$_SESSION['isAdmin']){
                if(!empty($_POST['suspendre'])&&$this->_global['db']->setLocked($this->_user->getId(),1)) {
                    $_SESSION['code'] = "S7";
                    header("Location: /user/".$this->_user->getUsername());
                }
                
                if(!empty($_POST['enLigne'])&&$this->_global['db']->setLocked($this->_user->getId(),0)) {

                    $_SESSION['code'] = "S9";
                    header("Location: /user/".$this->_user->getUsername());
                }
            }
            
            if(isset($_SESSION['isConnected']) && $_SESSION['isConnected']&&$_SESSION['isAdmin'] ){
                if(!empty($_POST['Admin'])&&$this->_global['db']->setAdmin($this->_user->getId(),1)) {
                    $_SESSION['code'] = "S8";
                    header("Location: /user/".$this->_user->getUsername());

                }
                
                if(!empty($_POST['Membre'])&&$this->_global['db']->setAdmin($this->_user->getId(),0)) {
                    $_SESSION['code'] = "S10";
                    header("Location: /user/".$this->_user->getUsername());
                }
            }
            require_once (PATH_VIEWS."user.php");
		}
	}