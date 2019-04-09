<?php
	class LoginController{
		private $_global;
		
		public function __construct($global) {
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
						header("Location: ".$_SESSION['referer']);
					}
				} else $errorMessage = "Nom d'utilisateur ou mot de passe incorrect...";
			}
			if (isset($_GET['error'])) {
				switch ($_GET['error']) {
					case 1:
						$errorMessage = "Vous devez être connecté pour voter...";
						break;
				}
			}
	        require_once(PATH_VIEWS.'login.php');
	    }
	}