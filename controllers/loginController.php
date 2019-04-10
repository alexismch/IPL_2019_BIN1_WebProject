<?php
	class LoginController{
		private $_global;
		
		public function __construct($global) {
			if (empty($_SESSION['referer'])) $_SESSION['referer'] = "/";
			$this->_global = $global;
			if (isset($_SESSION['isConnected']) && $_SESSION['isConnected']) {
				$_SESSION['code'] = "E0";
				header("Location: /");
				exit();
			}
			require_once (PATH_VIEWS."heads/loginHead.php");
	    }
	
	    public function run(){
			if (isset($_POST['login'])) {
				$user = $this->_global['db']->getUser($_POST['username']);
				if ($user != null && $user->isValidPasswd($_POST['passwd'])) {
					if ($user->isLocked()) $errorMessage = "Votre compte est actuellement bloqué...";
					else {
						$_SESSION['user'] = serialize($user);
						$_SESSION['isConnected'] = true;
						$_SESSION['code'] = "S0";
						if (isset($_SESSION['form'])) header("Location: ".$_SESSION['form']['formURL']);
						else header("Location: ".$_SESSION['referer']);
						exit();
					}
				} else $errorMessage = "Nom d'utilisateur ou mot de passe incorrect...";
			}
	        require_once(PATH_VIEWS.'login.php');
	    }
	}