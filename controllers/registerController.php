<?php
	class registerController {
		private $_global;
		
		public function __construct($global) {
			$this->_global = $global;
			if (isset($_SESSION['isConnected']) && $_SESSION['isConnected']) {#a member woh is connected cannot create an account
				$_SESSION['code'] = "E0";
				header("Location: /");
				exit();
			}
			require_once (PATH_VIEWS."heads/registerHead.php");
		}

        /**
         *
         */
        public function run(){
        	if (isset($_POST['register'])) {
		        if (!isset($_POST['name']) || empty($_POST['name']))#check if the name field is not empty
		        	$errorMessage = "Veuillez saisir un nom...";
		        else if (!isset($_POST['firstname']) || empty($_POST['firstname']))
		        	$errorMessage = "Veuillez saisir un prénom...";
		        else if (!isset($_POST['username']) || empty($_POST['username']))
		        	$errorMessage = "Veuillez saisir un nom d'utilisateur...";
		        else if (!isset($_POST['passwd']) || empty($_POST['passwd']))
		        	$errorMessage = "Veuillez saisir un mot de passe...";
		        else if (!isset($_POST['passwd-verify']) || empty($_POST['passwd-verify']))
		        	$errorMessage = "Veuillez saisir un mot de passe de vérification...";
		        else if ($_POST['passwd-verify'] !== $_POST['passwd'])
		        	$errorMessage = "Les deux mots de passe ne correspondent pas...";
		        else if (!isset($_POST['mail']) || empty($_POST['mail']))
		        	$errorMessage = "Veuillez saisir une adresse mail...";
		        else if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
		        	$errorMessage = "Veuillez saisir une adresse mail valide...";
		        else {
		        	$isOk = $this->_global['db']->insertUser($_POST['name'], $_POST['firstname'], $_POST['mail'], $_POST['username'], $_POST['passwd']);
		            if ($isOk === true) {
			            $_SESSION['code'] = "S6";
			            if (isset($_SESSION['form'])) header("Location: ".$_SESSION['form']['formURL']);
			            else header("Location: ".$_SESSION['referer']);
			            exit();
		            } else $errorMessage = $isOk;
		        }
	        }
            require_once(PATH_VIEWS.'register.php');
        }
	}